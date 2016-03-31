<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('computers.show') }}">
        <a title="Computer Details" href="{{ route('computers.show', [$computer->getKey()]) }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>

    <!--
    <li class="{{ active()->route('computers.patches.*') }}">
        <a title="Computer Details" href="{{ route('computers.patches.index', [$computer->getKey()]) }}">
            <i class="fa fa-medkit"></i>
            Patches
        </a>
    </li>
    -->

    <li class="{{ active()->route('computers.disks.*') }}">
        <a title="Computer Hard Disks" href="{{ route('computers.disks.index', [$computer->getKey()]) }}">
            <i class="fa fa-hdd-o"></i>
            Disks
        </a>
    </li>

    <li class="{{ active()->route('computers.access.edit') }}">
        <a title="Computer Settings" href="{{ route('computers.access.edit', [$computer->getKey()]) }}">
            <i class="fa fa-cogs"></i>
            Access
        </a>
    </li>

    <li>
        <a href="{{ route('computers.edit', [$computer->getKey()]) }}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    </li>

    <li>
        <a
                data-post="DELETE"
                data-title="Delete Computer?"
                data-message="Are you sure you want to delete this computer?"
                href="{{ route('computers.destroy', [$computer->getKey()]) }}"
        >
            <i class="fa fa-trash"></i>
            Delete
        </a>
    </li>

</ul>