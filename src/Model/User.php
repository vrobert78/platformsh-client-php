<?php

namespace Platformsh\Client\Model;

class User extends Resource
{

    /** @var array */
    protected static $required = ['email'];

    const ROLE_ADMIN = 'admin';
    const ROLE_VIEWER = 'viewer';

    /**
     * @inheritdoc
     */
    public static function check(array $data)
    {
        $errors = parent::check($data);
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address: '{$data['email']}'";
        }
        if (isset($data['role']) && !in_array($data['role'], [self::ROLE_ADMIN, self::ROLE_VIEWER])) {
            $errors[] = "Invalid role: '{$data['role']}";
        }
        return $errors;
    }

    /**
     * Check whether the user is editable.
     *
     * @return bool
     */
    public function isEditable()
    {
        return $this->operationAvailable('edit');
    }
}
