<?php

/**
 * Base class that represents a row from the 'conceptes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Jan 28 12:59:03 2010
 *
 * @package    lib.model.om
 */
abstract class BaseConceptes extends BaseObject  implements Persistent {


  const PEER = 'ConceptesPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ConceptesPeer
	 */
	protected static $peer;

	/**
	 * The value for the concepteid field.
	 * @var        int
	 */
	protected $concepteid;

	/**
	 * The value for the any field.
	 * @var        int
	 */
	protected $any;

	/**
	 * The value for the capitol field.
	 * @var        string
	 */
	protected $capitol;

	/**
	 * The value for the apartat field.
	 * @var        string
	 */
	protected $apartat;

	/**
	 * The value for the concepte field.
	 * @var        string
	 */
	protected $concepte;

	/**
	 * The value for the quantitat field.
	 * @var        double
	 */
	protected $quantitat;

	/**
	 * @var        array Factures[] Collection to store aggregation of Factures objects.
	 */
	protected $collFacturess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collFacturess.
	 */
	private $lastFacturesCriteria = null;

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

	/**
	 * Initializes internal state of BaseConceptes object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
	}

	/**
	 * Get the [concepteid] column value.
	 * 
	 * @return     int
	 */
	public function getConcepteid()
	{
		return $this->concepteid;
	}

	/**
	 * Get the [any] column value.
	 * 
	 * @return     int
	 */
	public function getAny()
	{
		return $this->any;
	}

	/**
	 * Get the [capitol] column value.
	 * 
	 * @return     string
	 */
	public function getCapitol()
	{
		return $this->capitol;
	}

	/**
	 * Get the [apartat] column value.
	 * 
	 * @return     string
	 */
	public function getApartat()
	{
		return $this->apartat;
	}

	/**
	 * Get the [concepte] column value.
	 * 
	 * @return     string
	 */
	public function getConcepte()
	{
		return $this->concepte;
	}

	/**
	 * Get the [quantitat] column value.
	 * 
	 * @return     double
	 */
	public function getQuantitat()
	{
		return $this->quantitat;
	}

	/**
	 * Set the value of [concepteid] column.
	 * 
	 * @param      int $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setConcepteid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->concepteid !== $v) {
			$this->concepteid = $v;
			$this->modifiedColumns[] = ConceptesPeer::CONCEPTEID;
		}

		return $this;
	} // setConcepteid()

	/**
	 * Set the value of [any] column.
	 * 
	 * @param      int $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setAny($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->any !== $v) {
			$this->any = $v;
			$this->modifiedColumns[] = ConceptesPeer::ANY;
		}

		return $this;
	} // setAny()

	/**
	 * Set the value of [capitol] column.
	 * 
	 * @param      string $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setCapitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->capitol !== $v) {
			$this->capitol = $v;
			$this->modifiedColumns[] = ConceptesPeer::CAPITOL;
		}

		return $this;
	} // setCapitol()

	/**
	 * Set the value of [apartat] column.
	 * 
	 * @param      string $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setApartat($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->apartat !== $v) {
			$this->apartat = $v;
			$this->modifiedColumns[] = ConceptesPeer::APARTAT;
		}

		return $this;
	} // setApartat()

	/**
	 * Set the value of [concepte] column.
	 * 
	 * @param      string $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setConcepte($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->concepte !== $v) {
			$this->concepte = $v;
			$this->modifiedColumns[] = ConceptesPeer::CONCEPTE;
		}

		return $this;
	} // setConcepte()

	/**
	 * Set the value of [quantitat] column.
	 * 
	 * @param      double $v new value
	 * @return     Conceptes The current object (for fluent API support)
	 */
	public function setQuantitat($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->quantitat !== $v) {
			$this->quantitat = $v;
			$this->modifiedColumns[] = ConceptesPeer::QUANTITAT;
		}

		return $this;
	} // setQuantitat()

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
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array())) {
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

			$this->concepteid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->any = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->capitol = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->apartat = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->concepte = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->quantitat = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = ConceptesPeer::NUM_COLUMNS - ConceptesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Conceptes object", $e);
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
			$con = Propel::getConnection(ConceptesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ConceptesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collFacturess = null;
			$this->lastFacturesCriteria = null;

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

    foreach (sfMixer::getCallables('BaseConceptes:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConceptesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ConceptesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseConceptes:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
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

    foreach (sfMixer::getCallables('BaseConceptes:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ConceptesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseConceptes:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			ConceptesPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = ConceptesPeer::CONCEPTEID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ConceptesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setConcepteid($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ConceptesPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collFacturess !== null) {
				foreach ($this->collFacturess as $referrerFK) {
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


			if (($retval = ConceptesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collFacturess !== null) {
					foreach ($this->collFacturess as $referrerFK) {
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
		$pos = ConceptesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getConcepteid();
				break;
			case 1:
				return $this->getAny();
				break;
			case 2:
				return $this->getCapitol();
				break;
			case 3:
				return $this->getApartat();
				break;
			case 4:
				return $this->getConcepte();
				break;
			case 5:
				return $this->getQuantitat();
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
		$keys = ConceptesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getConcepteid(),
			$keys[1] => $this->getAny(),
			$keys[2] => $this->getCapitol(),
			$keys[3] => $this->getApartat(),
			$keys[4] => $this->getConcepte(),
			$keys[5] => $this->getQuantitat(),
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
		$pos = ConceptesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setConcepteid($value);
				break;
			case 1:
				$this->setAny($value);
				break;
			case 2:
				$this->setCapitol($value);
				break;
			case 3:
				$this->setApartat($value);
				break;
			case 4:
				$this->setConcepte($value);
				break;
			case 5:
				$this->setQuantitat($value);
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
		$keys = ConceptesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setConcepteid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAny($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCapitol($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setApartat($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setConcepte($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setQuantitat($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);

		if ($this->isColumnModified(ConceptesPeer::CONCEPTEID)) $criteria->add(ConceptesPeer::CONCEPTEID, $this->concepteid);
		if ($this->isColumnModified(ConceptesPeer::ANY)) $criteria->add(ConceptesPeer::ANY, $this->any);
		if ($this->isColumnModified(ConceptesPeer::CAPITOL)) $criteria->add(ConceptesPeer::CAPITOL, $this->capitol);
		if ($this->isColumnModified(ConceptesPeer::APARTAT)) $criteria->add(ConceptesPeer::APARTAT, $this->apartat);
		if ($this->isColumnModified(ConceptesPeer::CONCEPTE)) $criteria->add(ConceptesPeer::CONCEPTE, $this->concepte);
		if ($this->isColumnModified(ConceptesPeer::QUANTITAT)) $criteria->add(ConceptesPeer::QUANTITAT, $this->quantitat);

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
		$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);

		$criteria->add(ConceptesPeer::CONCEPTEID, $this->concepteid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getConcepteid();
	}

	/**
	 * Generic method to set the primary key (concepteid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setConcepteid($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Conceptes (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAny($this->any);

		$copyObj->setCapitol($this->capitol);

		$copyObj->setApartat($this->apartat);

		$copyObj->setConcepte($this->concepte);

		$copyObj->setQuantitat($this->quantitat);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getFacturess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addFactures($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setConcepteid(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Conceptes Clone of current object.
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
	 * @return     ConceptesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ConceptesPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collFacturess collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addFacturess()
	 */
	public function clearFacturess()
	{
		$this->collFacturess = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collFacturess collection (array).
	 *
	 * By default this just sets the collFacturess collection to an empty array (like clearcollFacturess());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initFacturess()
	{
		$this->collFacturess = array();
	}

	/**
	 * Gets an array of Factures objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Conceptes has previously been saved, it will retrieve
	 * related Facturess from storage. If this Conceptes is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Factures[]
	 * @throws     PropelException
	 */
	public function getFacturess($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFacturess === null) {
			if ($this->isNew()) {
			   $this->collFacturess = array();
			} else {

				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				FacturesPeer::addSelectColumns($criteria);
				$this->collFacturess = FacturesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				FacturesPeer::addSelectColumns($criteria);
				if (!isset($this->lastFacturesCriteria) || !$this->lastFacturesCriteria->equals($criteria)) {
					$this->collFacturess = FacturesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastFacturesCriteria = $criteria;
		return $this->collFacturess;
	}

	/**
	 * Returns the number of related Factures objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Factures objects.
	 * @throws     PropelException
	 */
	public function countFacturess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collFacturess === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				$count = FacturesPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				if (!isset($this->lastFacturesCriteria) || !$this->lastFacturesCriteria->equals($criteria)) {
					$count = FacturesPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collFacturess);
				}
			} else {
				$count = count($this->collFacturess);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Factures object to this object
	 * through the Factures foreign key attribute.
	 *
	 * @param      Factures $l Factures
	 * @return     void
	 * @throws     PropelException
	 */
	public function addFactures(Factures $l)
	{
		if ($this->collFacturess === null) {
			$this->initFacturess();
		}
		if (!in_array($l, $this->collFacturess, true)) { // only add it if the **same** object is not already associated
			array_push($this->collFacturess, $l);
			$l->setConceptes($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Conceptes is new, it will return
	 * an empty collection; or if this Conceptes has previously
	 * been saved, it will retrieve related Facturess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Conceptes.
	 */
	public function getFacturessJoinProveidors($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFacturess === null) {
			if ($this->isNew()) {
				$this->collFacturess = array();
			} else {

				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				$this->collFacturess = FacturesPeer::doSelectJoinProveidors($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

			if (!isset($this->lastFacturesCriteria) || !$this->lastFacturesCriteria->equals($criteria)) {
				$this->collFacturess = FacturesPeer::doSelectJoinProveidors($criteria, $con, $join_behavior);
			}
		}
		$this->lastFacturesCriteria = $criteria;

		return $this->collFacturess;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Conceptes is new, it will return
	 * an empty collection; or if this Conceptes has previously
	 * been saved, it will retrieve related Facturess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Conceptes.
	 */
	public function getFacturessJoinUsuaris($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ConceptesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collFacturess === null) {
			if ($this->isNew()) {
				$this->collFacturess = array();
			} else {

				$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

				$this->collFacturess = FacturesPeer::doSelectJoinUsuaris($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(FacturesPeer::CONCEPTES_CONCEPTEID, $this->concepteid);

			if (!isset($this->lastFacturesCriteria) || !$this->lastFacturesCriteria->equals($criteria)) {
				$this->collFacturess = FacturesPeer::doSelectJoinUsuaris($criteria, $con, $join_behavior);
			}
		}
		$this->lastFacturesCriteria = $criteria;

		return $this->collFacturess;
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
			if ($this->collFacturess) {
				foreach ((array) $this->collFacturess as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collFacturess = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseConceptes:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseConceptes::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseConceptes
