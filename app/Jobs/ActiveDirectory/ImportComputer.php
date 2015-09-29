<?php

namespace App\Jobs\ActiveDirectory;

use App\Jobs\Computers\Create as CreateComputer;
use App\Jobs\Computers\CreateOs;
use App\Jobs\Computers\CreateType;
use App\Jobs\Job;
use Adldap\Models\Computer as AdComputer;
use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\OperatingSystem;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ImportComputer extends Job implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var AdComputer
     */
    protected $computer;

    /**
     * Constructor.
     *
     * @param AdComputer $computer
     */
    public function __construct(AdComputer $computer)
    {
        $this->computer = $computer;
    }

    /**
     * Creates a computer from an AD Computer model instance.
     *
     * @return Computer|bool
     */
    public function handle()
    {
        $operatingSystem = $this->computer->getOperatingSystem();
        $version = $this->computer->getOperatingSystemVersion();
        $servicePack = $this->computer->getOperatingSystemServicePack();

        $os = $this->dispatch(new CreateOs($operatingSystem, $version, $servicePack));
        $type = $this->dispatch((new CreateType(null))->fromOs($operatingSystem));

        // Make sure the OS has been created, otherwise we'll set the
        // ID to null if the computer doesn't have an OS record.
        if ($os instanceof OperatingSystem) {
            $osId = $os->getKey();
        } else {
            $osId = null;
        }

        // Make sure the computer type has been created, otherwise we'll set the
        // ID to null if the computer doesn't have a type associated.
        if ($type instanceof ComputerType) {
            $typeId = $type->getKey();
        } else {
            $typeId = null;
        }

        $name = $this->computer->getCommonName();
        $description = $this->computer->getDescription();
        $dn = $this->computer->getDn();

        $job = new CreateComputer($typeId, $osId, $name, $description, $dn);

        $computer = $this->dispatch($job);

        if ($computer instanceof Computer) {
            $this->dispatch(new CreateComputerAccess($computer->getKey()));

            return $computer;
        }

        return false;
    }
}