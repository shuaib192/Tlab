<?php

if (! function_exists('feature')) {
    function feature($key, $user = null)
    {
        return \App\Models\FeatureFlag::isEnabled($key, $user ?? auth()->user());
    }
}
