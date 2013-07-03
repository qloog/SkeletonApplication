<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;

class SysOptionsTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function	getSysOption($cfg_id)
	{
		$rowset = $this->tableGateway->select(array('cfg_id' => $cfg_id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Excpetion("Could not find row $cfg_id");
		}
		return $row;
	}

	public function saveSysOptions(SysOptions $SysOptions)
	{
		$data = array(
			'cfg_site_url' => $SysOptions->cfg_site_url,
			'cfg_site_name' => $SysOptions->cfg_site_name,
		);
		$cfg_id = (int)$SysOptions->cfg_id;
		if ($cfg_id == 0) {
			return $this->tableGateway->insert($data);
		} else {
			if ($this->getSysoptions($cfg_id)) {
			return $this->tableGateway->update($data, array('cfg_id' => $cfg_id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteSysoptions($id) 
	{
		$this->tableGateway->delete(array('cfg_id' => $id));
	}
}
			
