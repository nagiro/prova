<?php

/**
 * Base class that represents a row from the 'espais_externs' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/07/11 13:54:23
 *
 * @package    lib.model.om
 */
abstract class BaseEspaisExterns extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EspaisExternsPeer
	 */
	protected static $peer;

	/**
	 * The value for the idespaiextern field.
	 * @var        int
	 */
	protected $idespaiextern;

	/**
	 * The value for the poble field.
	 * @var        int
	 */
	protected $poble;

	/**
	 * The value for the nom field.
	 * @var        string
	 */
	protected $nom;

	/**
	 * The value for the adreca field.
	 * @var        string
	 */
	protected $adreca;

	/**
	 * The value for the contacte field.
	 * @var        string
	 */
	protected $contacte;

	/**
	 * The value for the actiu field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $actiu;

	/**
	 * @var        Poblacions
	 */
	protected $aPoblacions;

	/**
	 * @var        array Horarisespais[] Collection to store aggregation of Horarisespais objects.
	 */
	protected $collHorarisespaiss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collHorarisespaiss.
	 */
	private $lastHorarisespaisCriteria = null;

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
	
	const PEER = 'EspaisExternsPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->actiu = 1;
	}

	/**
	 * Initializes internal state of BaseEspaisExterns object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [idespaiextern] column value.
	 * 
	 * @return     int
	 */
	public function getIdespaiextern()
	{
		return $this->idespaiextern;
	}

	/**
	 * Get the [poble] column value.
	 * 
	 * @return     int
	 */
	public function getPoble()
	{
		return $this->poble;
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
	 * Get the [adreca] column value.
	 * 
	 * @return     string
	 */
	public function getAdreca()
	{
		return $this->adreca;
	}

	/**
	 * Get the [contacte] column value.
	 * 
	 * @return     string
	 */
	public function getContacte()
	{
		return $this->contacte;
	}

	/**
	 * Get the [actiu] column value.
	 * 
	 * @return     int
	 */
	public function getActiu()
	{
		return $this->actiu;
	}

	/**
	 * Set the value of [idespaiextern] column.
	 * 
	 * @param      int $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setIdespaiextern($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idespaiextern !== $v) {
			$this->idespaiextern = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::IDESPAIEXTERN;
		}

		return $this;
	} // setIdespaiextern()

	/**
	 * Set the value of [poble] column.
	 * 
	 * @param      int $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setPoble($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->poble !== $v) {
			$this->poble = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::POBLE;
		}

		if ($this->aPoblacions !== null && $this->aPoblacions->getIdpoblacio() !== $v) {
			$this->aPoblacions = null;
		}

		return $this;
	} // setPoble()

	/**
	 * Set the value of [nom] column.
	 * 
	 * @param      string $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setNom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom !== $v) {
			$this->nom = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::NOM;
		}

		return $this;
	} // setNom()

	/**
	 * Set the value of [adreca] column.
	 * 
	 * @param      string $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setAdreca($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->adreca !== $v) {
			$this->adreca = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::ADRECA;
		}

		return $this;
	} // setAdreca()

	/**
	 * Set the value of [contacte] column.
	 * 
	 * @param      string $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setContacte($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->contacte !== $v) {
			$this->contacte = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::CONTACTE;
		}

		return $this;
	} // setContacte()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     EspaisExterns The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = EspaisExternsPeer::ACTIU;
		}

		return $this;
	} // setActiu()

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
			if ($this->actiu !== 1) {
				return false;
			}

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

			$this->idespaiextern = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->poble = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->nom = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->adreca = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->contacte = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->actiu = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = EspaisExternsPeer::NUM_COLUMNS - EspaisExternsPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating EspaisExterns object", $e);
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

		if ($this->aPoblacions !== null && $this->poble !== $this->aPoblacions->getIdpoblacio()) {
			$this->aPoblacions = null;
		}
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
			$con = Propel::getConnection(EspaisExternsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EspaisExternsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPoblacions = null;
			$this->collHorarisespaiss = null;
			$this->lastHorarisespaisCriteria = null;

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
			$con = Propel::getConnection(EspaisExternsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEspaisExterns:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EspaisExternsPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEspaisExterns:delete:post') as $callable)
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
			$con = Propel::getConnection(EspaisExternsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEspaisExterns:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseEspaisExterns:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EspaisExternsPeer::addInstanceToPool($this);
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

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPoblacions !== null) {
				if ($this->aPoblacions->isModified() || $this->aPoblacions->isNew()) {
					$affectedRows += $this->aPoblacions->save($con);
				}
				$this->setPoblacions($this->aPoblacions);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = EspaisExternsPeer::IDESPAIEXTERN;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EspaisExternsPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdespaiextern($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += EspaisExternsPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collHorarisespaiss !== null) {
				foreach ($this->collHorarisespaiss as $referrerFK) {
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPoblacions !== null) {
				if (!$this->aPoblacions->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPoblacions->getValidationFailures());
				}
			}


			if (($retval = EspaisExternsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collHorarisespaiss !== null) {
					foreach ($this->collHorarisespaiss as $referrerFK) {
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
		$pos = EspaisExternsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdespaiextern();
				break;
			case 1:
				return $this->getPoble();
				break;
			case 2:
				return $this->getNom();
				break;
			case 3:
				return $this->getAdreca();
				break;
			case 4:
				return $this->getContacte();
				break;
			case 5:
				return $this->getActiu();
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
		$keys = EspaisExternsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdespaiextern(),
			$keys[1] => $this->getPoble(),
			$keys[2] => $this->getNom(),
			$keys[3] => $this->getAdreca(),
			$keys[4] => $this->getContacte(),
			$keys[5] => $this->getActiu(),
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
		$pos = EspaisExternsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdespaiextern($value);
				break;
			case 1:
				$this->setPoble($value);
				break;
			case 2:
				$this->setNom($value);
				break;
			case 3:
				$this->setAdreca($value);
				break;
			case 4:
				$this->setContacte($value);
				break;
			case 5:
				$this->setActiu($value);
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
		$keys = EspaisExternsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdespaiextern($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPoble($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNom($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAdreca($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContacte($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setActiu($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);

		if ($this->isColumnModified(EspaisExternsPeer::IDESPAIEXTERN)) $criteria->add(EspaisExternsPeer::IDESPAIEXTERN, $this->idespaiextern);
		if ($this->isColumnModified(EspaisExternsPeer::POBLE)) $criteria->add(EspaisExternsPeer::POBLE, $this->poble);
		if ($this->isColumnModified(EspaisExternsPeer::NOM)) $criteria->add(EspaisExternsPeer::NOM, $this->nom);
		if ($this->isColumnModified(EspaisExternsPeer::ADRECA)) $criteria->add(EspaisExternsPeer::ADRECA, $this->adreca);
		if ($this->isColumnModified(EspaisExternsPeer::CONTACTE)) $criteria->add(EspaisExternsPeer::CONTACTE, $this->contacte);
		if ($this->isColumnModified(EspaisExternsPeer::ACTIU)) $criteria->add(EspaisExternsPeer::ACTIU, $this->actiu);

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
		$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);

		$criteria->add(EspaisExternsPeer::IDESPAIEXTERN, $this->idespaiextern);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdespaiextern();
	}

	/**
	 * Generic method to set the primary key (idespaiextern column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdespaiextern($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of EspaisExterns (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setPoble($this->poble);

		$copyObj->setNom($this->nom);

		$copyObj->setAdreca($this->adreca);

		$copyObj->setContacte($this->contacte);

		$copyObj->setActiu($this->actiu);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getHorarisespaiss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addHorarisespais($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setIdespaiextern(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     EspaisExterns Clone of current object.
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
	 * @return     EspaisExternsPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EspaisExternsPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Poblacions object.
	 *
	 * @param      Poblacions $v
	 * @return     EspaisExterns The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPoblacions(Poblacions $v = null)
	{
		if ($v === null) {
			$this->setPoble(NULL);
		} else {
			$this->setPoble($v->getIdpoblacio());
		}

		$this->aPoblacions = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Poblacions object, it will not be re-added.
		if ($v !== null) {
			$v->addEspaisExterns($this);
		}

		return $this;
	}


	/**
	 * Get the associated Poblacions object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Poblacions The associated Poblacions object.
	 * @throws     PropelException
	 */
	public function getPoblacions(PropelPDO $con = null)
	{
		if ($this->aPoblacions === null && ($this->poble !== null)) {
			$this->aPoblacions = PoblacionsPeer::retrieveByPk($this->poble);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPoblacions->addEspaisExternss($this);
			 */
		}
		return $this->aPoblacions;
	}

	/**
	 * Clears out the collHorarisespaiss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addHorarisespaiss()
	 */
	public function clearHorarisespaiss()
	{
		$this->collHorarisespaiss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collHorarisespaiss collection (array).
	 *
	 * By default this just sets the collHorarisespaiss collection to an empty array (like clearcollHorarisespaiss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initHorarisespaiss()
	{
		$this->collHorarisespaiss = array();
	}

	/**
	 * Gets an array of Horarisespais objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this EspaisExterns has previously been saved, it will retrieve
	 * related Horarisespaiss from storage. If this EspaisExterns is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Horarisespais[]
	 * @throws     PropelException
	 */
	public function getHorarisespaiss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
			   $this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				HorarisespaisPeer::addSelectColumns($criteria);
				$this->collHorarisespaiss = HorarisespaisPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				HorarisespaisPeer::addSelectColumns($criteria);
				if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
					$this->collHorarisespaiss = HorarisespaisPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;
		return $this->collHorarisespaiss;
	}

	/**
	 * Returns the number of related Horarisespais objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Horarisespais objects.
	 * @throws     PropelException
	 */
	public function countHorarisespaiss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				$count = HorarisespaisPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
					$count = HorarisespaisPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collHorarisespaiss);
				}
			} else {
				$count = count($this->collHorarisespaiss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Horarisespais object to this object
	 * through the Horarisespais foreign key attribute.
	 *
	 * @param      Horarisespais $l Horarisespais
	 * @return     void
	 * @throws     PropelException
	 */
	public function addHorarisespais(Horarisespais $l)
	{
		if ($this->collHorarisespaiss === null) {
			$this->initHorarisespaiss();
		}
		if (!in_array($l, $this->collHorarisespaiss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collHorarisespaiss, $l);
			$l->setEspaisExterns($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this EspaisExterns is new, it will return
	 * an empty collection; or if this EspaisExterns has previously
	 * been saved, it will retrieve related Horarisespaiss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in EspaisExterns.
	 */
	public function getHorarisespaissJoinMaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinMaterial($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

			if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinMaterial($criteria, $con, $join_behavior);
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;

		return $this->collHorarisespaiss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this EspaisExterns is new, it will return
	 * an empty collection; or if this EspaisExterns has previously
	 * been saved, it will retrieve related Horarisespaiss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in EspaisExterns.
	 */
	public function getHorarisespaissJoinEspais($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinEspais($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

			if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinEspais($criteria, $con, $join_behavior);
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;

		return $this->collHorarisespaiss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this EspaisExterns is new, it will return
	 * an empty collection; or if this EspaisExterns has previously
	 * been saved, it will retrieve related Horarisespaiss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in EspaisExterns.
	 */
	public function getHorarisespaissJoinHoraris($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(EspaisExternsPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collHorarisespaiss === null) {
			if ($this->isNew()) {
				$this->collHorarisespaiss = array();
			} else {

				$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinHoraris($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(HorarisespaisPeer::IDESPAIEXTERN, $this->idespaiextern);

			if (!isset($this->lastHorarisespaisCriteria) || !$this->lastHorarisespaisCriteria->equals($criteria)) {
				$this->collHorarisespaiss = HorarisespaisPeer::doSelectJoinHoraris($criteria, $con, $join_behavior);
			}
		}
		$this->lastHorarisespaisCriteria = $criteria;

		return $this->collHorarisespaiss;
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
			if ($this->collHorarisespaiss) {
				foreach ((array) $this->collHorarisespaiss as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collHorarisespaiss = null;
			$this->aPoblacions = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseEspaisExterns:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEspaisExterns::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEspaisExterns
