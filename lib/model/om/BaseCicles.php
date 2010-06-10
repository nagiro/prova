<?php

/**
 * Base class that represents a row from the 'cicles' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/04/10 12:54:27
 *
 * @package    lib.model.om
 */
abstract class BaseCicles extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        CiclesPeer
	 */
	protected static $peer;

	/**
	 * The value for the cicleid field.
	 * @var        int
	 */
	protected $cicleid;

	/**
	 * The value for the nom field.
	 * @var        string
	 */
	protected $nom;

	/**
	 * The value for the imatge field.
	 * @var        string
	 */
	protected $imatge;

	/**
	 * The value for the pdf field.
	 * @var        string
	 */
	protected $pdf;

	/**
	 * The value for the tcurt field.
	 * @var        string
	 */
	protected $tcurt;

	/**
	 * The value for the dcurt field.
	 * @var        string
	 */
	protected $dcurt;

	/**
	 * The value for the tmig field.
	 * @var        string
	 */
	protected $tmig;

	/**
	 * The value for the dmig field.
	 * @var        string
	 */
	protected $dmig;

	/**
	 * The value for the tcomplet field.
	 * @var        string
	 */
	protected $tcomplet;

	/**
	 * The value for the dcomplet field.
	 * @var        string
	 */
	protected $dcomplet;

	/**
	 * @var        array Activitats[] Collection to store aggregation of Activitats objects.
	 */
	protected $collActivitatss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collActivitatss.
	 */
	private $lastActivitatsCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'CiclesPeer';

	/**
	 * Get the [cicleid] column value.
	 * 
	 * @return     int
	 */
	public function getCicleid()
	{
		return $this->cicleid;
	}

	/**
	 * Get the [nom] column value.
	 * 
	 * @return     string
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * Get the [imatge] column value.
	 * 
	 * @return     string
	 */
	public function getImatge()
	{
		return $this->imatge;
	}

	/**
	 * Get the [pdf] column value.
	 * 
	 * @return     string
	 */
	public function getPdf()
	{
		return $this->pdf;
	}

	/**
	 * Get the [tcurt] column value.
	 * 
	 * @return     string
	 */
	public function getTcurt()
	{
		return $this->tcurt;
	}

	/**
	 * Get the [dcurt] column value.
	 * 
	 * @return     string
	 */
	public function getDcurt()
	{
		return $this->dcurt;
	}

	/**
	 * Get the [tmig] column value.
	 * 
	 * @return     string
	 */
	public function getTmig()
	{
		return $this->tmig;
	}

	/**
	 * Get the [dmig] column value.
	 * 
	 * @return     string
	 */
	public function getDmig()
	{
		return $this->dmig;
	}

	/**
	 * Get the [tcomplet] column value.
	 * 
	 * @return     string
	 */
	public function getTcomplet()
	{
		return $this->tcomplet;
	}

	/**
	 * Get the [dcomplet] column value.
	 * 
	 * @return     string
	 */
	public function getDcomplet()
	{
		return $this->dcomplet;
	}

	/**
	 * Set the value of [cicleid] column.
	 * 
	 * @param      int $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setCicleid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->cicleid !== $v) {
			$this->cicleid = $v;
			$this->modifiedColumns[] = CiclesPeer::CICLEID;
		}

		return $this;
	} // setCicleid()

	/**
	 * Set the value of [nom] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setNom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom !== $v) {
			$this->nom = $v;
			$this->modifiedColumns[] = CiclesPeer::NOM;
		}

		return $this;
	} // setNom()

	/**
	 * Set the value of [imatge] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setImatge($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->imatge !== $v) {
			$this->imatge = $v;
			$this->modifiedColumns[] = CiclesPeer::IMATGE;
		}

		return $this;
	} // setImatge()

	/**
	 * Set the value of [pdf] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setPdf($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->pdf !== $v) {
			$this->pdf = $v;
			$this->modifiedColumns[] = CiclesPeer::PDF;
		}

		return $this;
	} // setPdf()

	/**
	 * Set the value of [tcurt] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setTcurt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tcurt !== $v) {
			$this->tcurt = $v;
			$this->modifiedColumns[] = CiclesPeer::TCURT;
		}

		return $this;
	} // setTcurt()

	/**
	 * Set the value of [dcurt] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setDcurt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->dcurt !== $v) {
			$this->dcurt = $v;
			$this->modifiedColumns[] = CiclesPeer::DCURT;
		}

		return $this;
	} // setDcurt()

	/**
	 * Set the value of [tmig] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setTmig($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tmig !== $v) {
			$this->tmig = $v;
			$this->modifiedColumns[] = CiclesPeer::TMIG;
		}

		return $this;
	} // setTmig()

	/**
	 * Set the value of [dmig] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setDmig($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->dmig !== $v) {
			$this->dmig = $v;
			$this->modifiedColumns[] = CiclesPeer::DMIG;
		}

		return $this;
	} // setDmig()

	/**
	 * Set the value of [tcomplet] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setTcomplet($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tcomplet !== $v) {
			$this->tcomplet = $v;
			$this->modifiedColumns[] = CiclesPeer::TCOMPLET;
		}

		return $this;
	} // setTcomplet()

	/**
	 * Set the value of [dcomplet] column.
	 * 
	 * @param      string $v new value
	 * @return     Cicles The current object (for fluent API support)
	 */
	public function setDcomplet($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->dcomplet !== $v) {
			$this->dcomplet = $v;
			$this->modifiedColumns[] = CiclesPeer::DCOMPLET;
		}

		return $this;
	} // setDcomplet()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->cicleid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nom = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->imatge = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->pdf = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->tcurt = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->dcurt = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->tmig = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->dmig = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->tcomplet = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->dcomplet = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = CiclesPeer::NUM_COLUMNS - CiclesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Cicles object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CiclesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = CiclesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collActivitatss = null;
			$this->lastActivitatsCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CiclesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseCicles:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				CiclesPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseCicles:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CiclesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseCicles:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseCicles:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				CiclesPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = CiclesPeer::CICLEID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CiclesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setCicleid($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += CiclesPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collActivitatss !== null) {
				foreach ($this->collActivitatss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = CiclesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collActivitatss !== null) {
					foreach ($this->collActivitatss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CiclesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCicleid();
				break;
			case 1:
				return $this->getNom();
				break;
			case 2:
				return $this->getImatge();
				break;
			case 3:
				return $this->getPdf();
				break;
			case 4:
				return $this->getTcurt();
				break;
			case 5:
				return $this->getDcurt();
				break;
			case 6:
				return $this->getTmig();
				break;
			case 7:
				return $this->getDmig();
				break;
			case 8:
				return $this->getTcomplet();
				break;
			case 9:
				return $this->getDcomplet();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = CiclesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCicleid(),
			$keys[1] => $this->getNom(),
			$keys[2] => $this->getImatge(),
			$keys[3] => $this->getPdf(),
			$keys[4] => $this->getTcurt(),
			$keys[5] => $this->getDcurt(),
			$keys[6] => $this->getTmig(),
			$keys[7] => $this->getDmig(),
			$keys[8] => $this->getTcomplet(),
			$keys[9] => $this->getDcomplet(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CiclesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCicleid($value);
				break;
			case 1:
				$this->setNom($value);
				break;
			case 2:
				$this->setImatge($value);
				break;
			case 3:
				$this->setPdf($value);
				break;
			case 4:
				$this->setTcurt($value);
				break;
			case 5:
				$this->setDcurt($value);
				break;
			case 6:
				$this->setTmig($value);
				break;
			case 7:
				$this->setDmig($value);
				break;
			case 8:
				$this->setTcomplet($value);
				break;
			case 9:
				$this->setDcomplet($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CiclesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCicleid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNom($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setImatge($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPdf($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTcurt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDcurt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTmig($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDmig($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTcomplet($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDcomplet($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(CiclesPeer::DATABASE_NAME);

		if ($this->isColumnModified(CiclesPeer::CICLEID)) $criteria->add(CiclesPeer::CICLEID, $this->cicleid);
		if ($this->isColumnModified(CiclesPeer::NOM)) $criteria->add(CiclesPeer::NOM, $this->nom);
		if ($this->isColumnModified(CiclesPeer::IMATGE)) $criteria->add(CiclesPeer::IMATGE, $this->imatge);
		if ($this->isColumnModified(CiclesPeer::PDF)) $criteria->add(CiclesPeer::PDF, $this->pdf);
		if ($this->isColumnModified(CiclesPeer::TCURT)) $criteria->add(CiclesPeer::TCURT, $this->tcurt);
		if ($this->isColumnModified(CiclesPeer::DCURT)) $criteria->add(CiclesPeer::DCURT, $this->dcurt);
		if ($this->isColumnModified(CiclesPeer::TMIG)) $criteria->add(CiclesPeer::TMIG, $this->tmig);
		if ($this->isColumnModified(CiclesPeer::DMIG)) $criteria->add(CiclesPeer::DMIG, $this->dmig);
		if ($this->isColumnModified(CiclesPeer::TCOMPLET)) $criteria->add(CiclesPeer::TCOMPLET, $this->tcomplet);
		if ($this->isColumnModified(CiclesPeer::DCOMPLET)) $criteria->add(CiclesPeer::DCOMPLET, $this->dcomplet);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CiclesPeer::DATABASE_NAME);

		$criteria->add(CiclesPeer::CICLEID, $this->cicleid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getCicleid();
	}

	/**
	 * Generic method to set the primary key (cicleid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setCicleid($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Cicles (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNom($this->nom);

		$copyObj->setImatge($this->imatge);

		$copyObj->setPdf($this->pdf);

		$copyObj->setTcurt($this->tcurt);

		$copyObj->setDcurt($this->dcurt);

		$copyObj->setTmig($this->tmig);

		$copyObj->setDmig($this->dmig);

		$copyObj->setTcomplet($this->tcomplet);

		$copyObj->setDcomplet($this->dcomplet);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getActivitatss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addActivitats($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setCicleid(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     Cicles Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     CiclesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CiclesPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collActivitatss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addActivitatss()
	 */
	public function clearActivitatss()
	{
		$this->collActivitatss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collActivitatss collection (array).
	 *
	 * By default this just sets the collActivitatss collection to an empty array (like clearcollActivitatss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initActivitatss()
	{
		$this->collActivitatss = array();
	}

	/**
	 * Gets an array of Activitats objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Cicles has previously been saved, it will retrieve
	 * related Activitatss from storage. If this Cicles is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Activitats[]
	 * @throws     PropelException
	 */
	public function getActivitatss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CiclesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collActivitatss === null) {
			if ($this->isNew()) {
			   $this->collActivitatss = array();
			} else {

				$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

				ActivitatsPeer::addSelectColumns($criteria);
				$this->collActivitatss = ActivitatsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

				ActivitatsPeer::addSelectColumns($criteria);
				if (!isset($this->lastActivitatsCriteria) || !$this->lastActivitatsCriteria->equals($criteria)) {
					$this->collActivitatss = ActivitatsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastActivitatsCriteria = $criteria;
		return $this->collActivitatss;
	}

	/**
	 * Returns the number of related Activitats objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Activitats objects.
	 * @throws     PropelException
	 */
	public function countActivitatss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CiclesPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collActivitatss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

				$count = ActivitatsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

				if (!isset($this->lastActivitatsCriteria) || !$this->lastActivitatsCriteria->equals($criteria)) {
					$count = ActivitatsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collActivitatss);
				}
			} else {
				$count = count($this->collActivitatss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Activitats object to this object
	 * through the Activitats foreign key attribute.
	 *
	 * @param      Activitats $l Activitats
	 * @return     void
	 * @throws     PropelException
	 */
	public function addActivitats(Activitats $l)
	{
		if ($this->collActivitatss === null) {
			$this->initActivitatss();
		}
		if (!in_array($l, $this->collActivitatss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collActivitatss, $l);
			$l->setCicles($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Cicles is new, it will return
	 * an empty collection; or if this Cicles has previously
	 * been saved, it will retrieve related Activitatss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Cicles.
	 */
	public function getActivitatssJoinTipusactivitat($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CiclesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collActivitatss === null) {
			if ($this->isNew()) {
				$this->collActivitatss = array();
			} else {

				$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

				$this->collActivitatss = ActivitatsPeer::doSelectJoinTipusactivitat($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(ActivitatsPeer::CICLES_CICLEID, $this->cicleid);

			if (!isset($this->lastActivitatsCriteria) || !$this->lastActivitatsCriteria->equals($criteria)) {
				$this->collActivitatss = ActivitatsPeer::doSelectJoinTipusactivitat($criteria, $con, $join_behavior);
			}
		}
		$this->lastActivitatsCriteria = $criteria;

		return $this->collActivitatss;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collActivitatss) {
				foreach ((array) $this->collActivitatss as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collActivitatss = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseCicles:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseCicles::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseCicles
