<?php

namespace App\Helpers;

class DynamicResourceHelper
{
    const RESOURCE_ADMIN_CONTENT_NAMESPACE = 'App\Http\Resources\Admin\Content\\';
    const RESOURCE_CONTENT_NAMESPACE = 'App\Http\Resources\Content\\';
    const RESOURCE_ADMIN_QUESTION_NAMESPACE = 'App\Http\Resources\Admin\Question\\';
    const RESOURCE_QUESTION_NAMESPACE = 'App\Http\Resources\Question\\';

    private static function define(string $resourceClass, mixed $content): mixed
    {
        if (class_exists($resourceClass)) {
            return new $resourceClass($content);
        }

        return $content;
    }

    public static function getContentAdminResource(string $type, mixed $content): mixed
    {
        $resourceClass = self::RESOURCE_ADMIN_CONTENT_NAMESPACE . ucfirst($type) . 'Resource';

        return self::define($resourceClass, $content);
    }

    public static function getContentResource(string $type, mixed $content): mixed
    {
        $resourceClass = self::RESOURCE_CONTENT_NAMESPACE . ucfirst($type) . 'Resource';

        return self::define($resourceClass, $content);
    }

    public static function getQuestionAdminResource(string $type, mixed $content): mixed
    {
        $resourceClass = self::RESOURCE_ADMIN_QUESTION_NAMESPACE . ucfirst($type) . 'Resource';

        return self::define($resourceClass, $content);
    }

    public static function getQuestionResource(string $type, mixed $content): mixed
    {
        $resourceClass = self::RESOURCE_QUESTION_NAMESPACE . ucfirst($type) . 'Resource';

        return self::define($resourceClass, $content);
    }
}
