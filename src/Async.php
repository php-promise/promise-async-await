<?php

namespace Promise\Support;

use Promise\Processors\Rejecter;
use Promise\Processors\Resolver;
use Promise\Promise;

if (!function_exists('async')) {
    /**
     * @param $callback
     * @return Promise
     * @throws \Promise\Exceptions\PromiseException
     */
    function async($callback) {
        return new Promise(function (Resolver $resolve, Rejecter $reject, $callback) {
            try {
                $resolve($callback());
            } catch (\Exception $e) {
                $reject($e);
            }
        }, $callback);
    }
}

if (!function_exists('await')) {
    /**
     * @param Promise $promise
     * @return mixed|null
     * @throws \Promise\Exceptions\PromiseException
     */
    function await(Promise $promise) {
        Promise::all($promise);
        return $promise->getContext()->getResult();
    }
}
