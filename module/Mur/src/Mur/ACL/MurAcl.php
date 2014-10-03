<?php
namespace ACL\MurAcl;
use Zend\Permissions\Acl\Acl as ZendAcl ;
use Zend\Permissions\Acl\Role\GenericRole as Role ;

/**
 * MyAcl
 *
 * @package Blog\Acl
 */
class MyAcl extends ZendAcl
{
    public function __construct() {
//add roles
        $this->addRole(new Role('guest'));
        $this->addRole(new Role('member'), 'Guest');
        $this->addRole(new Role('admin'));
//add resources
        $this->addResource('message');
        $this->addResource('user');
        $this->addResource('profile');
// Allow guests only to login
        $this->allow('guest', 'message', ['read']);
// Allow users to read and write posts
        $this->allow('member', 'message', ['create', 'read']);

// Allow admins everything
        $this->allow('admin');
    }
}