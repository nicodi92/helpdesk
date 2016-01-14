<?php

namespace App\Http;

use Illuminate\Support\Facades\Route;

class Active
{
    /**
     * The wildcard string.
     *
     * @var string
     */
    protected $wildcard = '*';

    /**
     * The output class string.
     *
     * @var string
     */
    protected $output = 'active';

    /**
     * The current route.
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
     * The current request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->request = request();
        $this->route = request()->route();
    }

    /**
     * Returns the output if the specified route
     * is the current route.
     *
     * @param string $route
     *
     * @return null|string
     */
    public function route($route)
    {
        $current = $this->route->getName();

        if ($this->containsWildcard($route)) {
            // If the specified route contains a wildcard we'll remove it.
            $route = $this->stripWildcard($route);

            if (str_contains($current, $route)) {
                // We'll check if the stripped route exists inside the current
                // route and return the output if that is the case.
                return $this->output;
            }
        }

        // If the route does not contain a wildcard we'll check if the
        // current route equals the specified route loosely.
        if ($current == $route) {
            return $this->output;
        }

        return;
    }

    /**
     * Returns the output if the current request
     * contains the specified key.
     *
     * @param string      $key
     * @param string|null $value
     *
     * @return string
     */
    public function input($key = '', $value = null)
    {
        if ($this->request->has($key)) {
            if (is_null($value)) {
                return $this->output;
            } elseif ($this->request->input($key) == $value) {
                return $this->output;
            }
        }

        return;
    }

    /**
     * Returns the output if one of the specified
     * routes are the current route.
     *
     * @param array $routes
     *
     * @return null|string
     */
    public function routes(array $routes = [])
    {
        foreach ($routes as $route) {
            $output = $this->route($route);

            if ($output) {
                return $output;
            }
        }

        return;
    }

    /**
     * Sets the output class string.
     *
     * @param string $output
     *
     * @return Active
     */
    public function output($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Returns true / false if the specified
     * string contains a wildcard.
     *
     * @param string $string
     *
     * @return bool
     */
    protected function containsWildcard($string)
    {
        return str_contains($string, $this->wildcard);
    }

    /**
     * Removes the wildcard from the specified string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function stripWildcard($string)
    {
        return str_replace($this->wildcard, null, $string);
    }
}
