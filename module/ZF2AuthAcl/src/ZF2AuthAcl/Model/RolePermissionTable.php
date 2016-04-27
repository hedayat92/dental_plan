<?php

namespace ZF2AuthAcl\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class RolePermissionTable extends AbstractTableGateway
{

    public $table = 'role_permission';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    public function getRolePermissions()
    {   
        $id= 1;
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from(array(
            't1' => 'role'
        ))
            ->columns(array(
            'role_name','rid'
        ))
            ->join(array(
            't2' => $this->table
        ), 't1.rid = t2.role_id', array('permission_id'), 'left')
            ->join(array(
            't3' => 'permission'
        ), 't3.id = t2.permission_id', array(
            'permission_name',
        ), 'left')
            ->join(array(
            't4' => 'resource'
        ), 't4.id = t3.resource_id', array(
            'resource_name'
        ), 'left')
            ->join(array(
            't5' => 'user_role'
        ), 't5.role_id = t1.rid', array(
            'id','user_id'
        ), 'left')
            ->where('t3.permission_name is not null and t4.resource_name is not null and t5.user_id='.$id)
            ->order('t1.rid');
              $sqlstring = $sql->getSqlStringForSqlObject($select);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($statement->execute())
            ->toArray(); 
        return $result;
    }
 
    public function getRolePermissionsuser($id)
    {   
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from(array(
            't1' => 'role'
        ))
            ->columns(array(
            'role_name','rid'
        ))
            ->join(array(
            't2' => $this->table
        ), 't1.rid = t2.role_id', array('permission_id'), 'left')
            ->join(array(
            't3' => 'permission'
        ), 't3.id = t2.permission_id', array(
            'permission_name','permission_url','client_id','cat_id'
        ), 'left')
            ->join(array(
            't5' => 'user_role'
        ), 't5.role_id = t1.rid', array(
            'id'
        ), 'left')
            ->where('t3.permission_name is not null  and t5.user_id='.$id)
            ->order('t3.id');
        //$sqlstring = $sql->getSqlStringForSqlObject($select);
        //echo 
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $this->resultSetPrototype->initialize($statement->execute())
            ->toArray();
        return $result;
    }
}

