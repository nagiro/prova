<?php

/**
 * Base class that represents a row from the 'tipus' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/19/12 09:28:10
 *
 * @package    lib.model.om
 */
abstract class BaseTipus extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TipusPeer
	 */
	protected static $peer;

	/**
	 * The value for the idtipus field.
	 * @var        int
	 */
	protected $idtipus;

	/**
	 * The value for the tipusnom field.
	 * @var        string
	 */
	protected $tipusnom;

	/**
	 * The value for the tipusdesc field.
	 * @var        string
	 */
	protected $tipusdesc;

	/**
	 * The value for the site_id field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $site_id;

	/**
	 * The value for the actiu field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $actiu;

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
	
	const PEER = 'TipusPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->site_id = 1;
		$this->actiu = 1;
	}

	/**
	 * Initializes internal state of BaseTipus object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [idtipus] column value.
	 * 
	 * @return     int
	 */
	public function getIdtipus()
	{
		return $this->idtipus;
	}

	/**
	 * Get the [tipusnom] column value.
	 * 
	 * @return     string
	 */
	public function getTipusnom()
	{
		return $this->tipusnom;
	}

	/**
	 * Get the [tipusdesc] column value.
	 * 
	 * @return     string
	 */
	public function getTipusdesc()
	{
		return $this->tipusdesc;
	}

	/**
	 * Get the [site_id] column value.
	 * 
	 * @return     int
	 */
	public function getSiteId()
	{
		return $this->site_id;
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
	 * Set the value of [idtipus] column.
	 * 
	 * @param      int $v new value
	 * @return     Tipus The current object (for fluent API support)
	 */
	public function setIdtipus($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idtipus !== $v) {
			$this->idtipus = $v;
			$this->modifiedColumns[] = TipusPeer::IDTIPUS;
		}

		return $this;
	} // setIdtipus()

	/**
	 * Set the value of [tipusnom] column.
	 * 
	 * @param      string $v new value
	 * @return     Tipus The current object (for fluent API support)
	 */
	public function setTipusnom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tipusnom !== $v) {
			$this->tipusnom = $v;
			$this->modifiedColumns[] = TipusPeer::TIPUSNOM;
		}

		return $this;
	} // setTipusnom()

	/**
	 * Set the value of [tipusdesc] column.
	 * 
	 * @param      string $v new value
	 * @return     Tipus The current object (for fluent API support)
	 */
	public function setTipusdesc($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tipusdesc !== $v) {
			$this->tipusdesc = $v;
			$this->modifiedColumns[] = TipusPeer::TIPUSDESC;
		}

		return $this;
	} // setTipusdesc()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Tipus The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v || $this->isNew()) {
			$this->site_id = $v;
			$this->modifiedColumns[] = TipusPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     Tipus The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = TipusPeer::ACTIU;
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
			if ($this->site_id !== 1) {
				return false;
			}

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

			$this->idtipus = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->tipusnom = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->tipusdesc = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->site_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->actiu = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = TipusPeer::NUM_COLUMNS - TipusPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Tipus object", $e);
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
			$con = Propel::getConnection(TipusPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = TipusPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

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
			$con = Propel::getConnection(TipusPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseTipus:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				TipusPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseTipus:delete:post') as $callable)
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
			$con = Propel::getConnection(TipusPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseTipus:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseTipus:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				TipusPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = TipusPeer::IDTIPUS;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TipusPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdtipus($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TipusPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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


			if (($retval = TipusPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = TipusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdtipus();
				break;
			case 1:
				return $this->getTipusnom();
				break;
			case 2:
				return $this->getTipusdesc();
				break;
			case 3:
				return $this->getSiteId();
				break;
			case 4:
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
		$keys = TipusPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdtipus(),
			$keys[1] => $this->getTipusnom(),
			$keys[2] => $this->getTipusdesc(),
			$keys[3] => $this->getSiteId(),
			$keys[4] => $this->getActiu(),
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
		$pos = TipusPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdtipus($value);
				break;
			case 1:
				$this->setTipusnom($value);
				break;
			case 2:
				$this->setTipusdesc($value);
				break;
			case 3:
				$this->setSiteId($value);
				break;
			case 4:
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
		$keys = TipusPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdtipus($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTipusnom($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipusdesc($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSiteId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActiu($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TipusPeer::DATABASE_NAME);

		if ($this->isColumnModified(TipusPeer::IDTIPUS)) $criteria->add(TipusPeer::IDTIPUS, $this->idtipus);
		if ($this->isColumnModified(TipusPeer::TIPUSNOM)) $criteria->add(TipusPeer::TIPUSNOM, $this->tipusnom);
		if ($this->isColumnModified(TipusPeer::TIPUSDESC)) $criteria->add(TipusPeer::TIPUSDESC, $this->tipusdesc);
		if ($this->isColumnModified(TipusPeer::SITE_ID)) $criteria->add(TipusPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(TipusPeer::ACTIU)) $criteria->add(TipusPeer::ACTIU, $this->actiu);

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
		$criteria = new Criteria(TipusPeer::DATABASE_NAME);

		$criteria->add(TipusPeer::IDTIPUS, $this->idtipus);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdtipus();
	}

	/**
	 * Generic method to set the primary key (idtipus column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdtipus($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Tipus (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTipusnom($this->tipusnom);

		$copyObj->setTipusdesc($this->tipusdesc);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);


		$copyObj->setNew(true);

		$copyObj->setIdtipus(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Tipus Clone of current object.
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
	 * @return     TipusPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TipusPeer();
		}
		return self::$peer;
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
		} // if ($deep)

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseTipus:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseTipus::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseTipus
