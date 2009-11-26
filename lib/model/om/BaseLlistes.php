<?php

/**
 * Base class that represents a row from the 'llistes' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Nov 26 11:47:44 2009
 *
 * @package    lib.model.om
 */
abstract class BaseLlistes extends BaseObject  implements Persistent {


  const PEER = 'LlistesPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        LlistesPeer
	 */
	protected static $peer;

	/**
	 * The value for the idllistes field.
	 * @var        int
	 */
	protected $idllistes;

	/**
	 * The value for the nom field.
	 * @var        string
	 */
	protected $nom;

	/**
	 * The value for the isactiva field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $isactiva;

	/**
	 * @var        array Missatgesllistes[] Collection to store aggregation of Missatgesllistes objects.
	 */
	protected $collMissatgesllistess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMissatgesllistess.
	 */
	private $lastMissatgesllistesCriteria = null;

	/**
	 * @var        array Usuarisllistes[] Collection to store aggregation of Usuarisllistes objects.
	 */
	protected $collUsuarisllistess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUsuarisllistess.
	 */
	private $lastUsuarisllistesCriteria = null;

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
	 * Initializes internal state of BaseLlistes object.
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
		$this->isactiva = 1;
	}

	/**
	 * Get the [idllistes] column value.
	 * 
	 * @return     int
	 */
	public function getIdllistes()
	{
		return $this->idllistes;
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
	 * Get the [isactiva] column value.
	 * 
	 * @return     int
	 */
	public function getIsactiva()
	{
		return $this->isactiva;
	}

	/**
	 * Set the value of [idllistes] column.
	 * 
	 * @param      int $v new value
	 * @return     Llistes The current object (for fluent API support)
	 */
	public function setIdllistes($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idllistes !== $v) {
			$this->idllistes = $v;
			$this->modifiedColumns[] = LlistesPeer::IDLLISTES;
		}

		return $this;
	} // setIdllistes()

	/**
	 * Set the value of [nom] column.
	 * 
	 * @param      string $v new value
	 * @return     Llistes The current object (for fluent API support)
	 */
	public function setNom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom !== $v) {
			$this->nom = $v;
			$this->modifiedColumns[] = LlistesPeer::NOM;
		}

		return $this;
	} // setNom()

	/**
	 * Set the value of [isactiva] column.
	 * 
	 * @param      int $v new value
	 * @return     Llistes The current object (for fluent API support)
	 */
	public function setIsactiva($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->isactiva !== $v || $v === 1) {
			$this->isactiva = $v;
			$this->modifiedColumns[] = LlistesPeer::ISACTIVA;
		}

		return $this;
	} // setIsactiva()

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
			if (array_diff($this->modifiedColumns, array(LlistesPeer::ISACTIVA))) {
				return false;
			}

			if ($this->isactiva !== 1) {
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

			$this->idllistes = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nom = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->isactiva = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = LlistesPeer::NUM_COLUMNS - LlistesPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Llistes object", $e);
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
			$con = Propel::getConnection(LlistesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = LlistesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collMissatgesllistess = null;
			$this->lastMissatgesllistesCriteria = null;

			$this->collUsuarisllistess = null;
			$this->lastUsuarisllistesCriteria = null;

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

    foreach (sfMixer::getCallables('BaseLlistes:delete:pre') as $callable)
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
			$con = Propel::getConnection(LlistesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			LlistesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseLlistes:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseLlistes:save:pre') as $callable)
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
			$con = Propel::getConnection(LlistesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseLlistes:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			LlistesPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = LlistesPeer::IDLLISTES;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LlistesPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdllistes($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += LlistesPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collMissatgesllistess !== null) {
				foreach ($this->collMissatgesllistess as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUsuarisllistess !== null) {
				foreach ($this->collUsuarisllistess as $referrerFK) {
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


			if (($retval = LlistesPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMissatgesllistess !== null) {
					foreach ($this->collMissatgesllistess as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUsuarisllistess !== null) {
					foreach ($this->collUsuarisllistess as $referrerFK) {
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
		$pos = LlistesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdllistes();
				break;
			case 1:
				return $this->getNom();
				break;
			case 2:
				return $this->getIsactiva();
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
		$keys = LlistesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdllistes(),
			$keys[1] => $this->getNom(),
			$keys[2] => $this->getIsactiva(),
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
		$pos = LlistesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdllistes($value);
				break;
			case 1:
				$this->setNom($value);
				break;
			case 2:
				$this->setIsactiva($value);
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
		$keys = LlistesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdllistes($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNom($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsactiva($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(LlistesPeer::DATABASE_NAME);

		if ($this->isColumnModified(LlistesPeer::IDLLISTES)) $criteria->add(LlistesPeer::IDLLISTES, $this->idllistes);
		if ($this->isColumnModified(LlistesPeer::NOM)) $criteria->add(LlistesPeer::NOM, $this->nom);
		if ($this->isColumnModified(LlistesPeer::ISACTIVA)) $criteria->add(LlistesPeer::ISACTIVA, $this->isactiva);

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
		$criteria = new Criteria(LlistesPeer::DATABASE_NAME);

		$criteria->add(LlistesPeer::IDLLISTES, $this->idllistes);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdllistes();
	}

	/**
	 * Generic method to set the primary key (idllistes column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdllistes($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Llistes (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNom($this->nom);

		$copyObj->setIsactiva($this->isactiva);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getMissatgesllistess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addMissatgesllistes($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUsuarisllistess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUsuarisllistes($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setIdllistes(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Llistes Clone of current object.
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
	 * @return     LlistesPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new LlistesPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collMissatgesllistess collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addMissatgesllistess()
	 */
	public function clearMissatgesllistess()
	{
		$this->collMissatgesllistess = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collMissatgesllistess collection (array).
	 *
	 * By default this just sets the collMissatgesllistess collection to an empty array (like clearcollMissatgesllistess());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initMissatgesllistess()
	{
		$this->collMissatgesllistess = array();
	}

	/**
	 * Gets an array of Missatgesllistes objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Llistes has previously been saved, it will retrieve
	 * related Missatgesllistess from storage. If this Llistes is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Missatgesllistes[]
	 * @throws     PropelException
	 */
	public function getMissatgesllistess($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMissatgesllistess === null) {
			if ($this->isNew()) {
			   $this->collMissatgesllistess = array();
			} else {

				$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				MissatgesllistesPeer::addSelectColumns($criteria);
				$this->collMissatgesllistess = MissatgesllistesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				MissatgesllistesPeer::addSelectColumns($criteria);
				if (!isset($this->lastMissatgesllistesCriteria) || !$this->lastMissatgesllistesCriteria->equals($criteria)) {
					$this->collMissatgesllistess = MissatgesllistesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMissatgesllistesCriteria = $criteria;
		return $this->collMissatgesllistess;
	}

	/**
	 * Returns the number of related Missatgesllistes objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Missatgesllistes objects.
	 * @throws     PropelException
	 */
	public function countMissatgesllistess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collMissatgesllistess === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				$count = MissatgesllistesPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				if (!isset($this->lastMissatgesllistesCriteria) || !$this->lastMissatgesllistesCriteria->equals($criteria)) {
					$count = MissatgesllistesPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collMissatgesllistess);
				}
			} else {
				$count = count($this->collMissatgesllistess);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Missatgesllistes object to this object
	 * through the Missatgesllistes foreign key attribute.
	 *
	 * @param      Missatgesllistes $l Missatgesllistes
	 * @return     void
	 * @throws     PropelException
	 */
	public function addMissatgesllistes(Missatgesllistes $l)
	{
		if ($this->collMissatgesllistess === null) {
			$this->initMissatgesllistess();
		}
		if (!in_array($l, $this->collMissatgesllistess, true)) { // only add it if the **same** object is not already associated
			array_push($this->collMissatgesllistess, $l);
			$l->setLlistes($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Llistes is new, it will return
	 * an empty collection; or if this Llistes has previously
	 * been saved, it will retrieve related Missatgesllistess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Llistes.
	 */
	public function getMissatgesllistessJoinMissatgesmailing($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMissatgesllistess === null) {
			if ($this->isNew()) {
				$this->collMissatgesllistess = array();
			} else {

				$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				$this->collMissatgesllistess = MissatgesllistesPeer::doSelectJoinMissatgesmailing($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(MissatgesllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

			if (!isset($this->lastMissatgesllistesCriteria) || !$this->lastMissatgesllistesCriteria->equals($criteria)) {
				$this->collMissatgesllistess = MissatgesllistesPeer::doSelectJoinMissatgesmailing($criteria, $con, $join_behavior);
			}
		}
		$this->lastMissatgesllistesCriteria = $criteria;

		return $this->collMissatgesllistess;
	}

	/**
	 * Clears out the collUsuarisllistess collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUsuarisllistess()
	 */
	public function clearUsuarisllistess()
	{
		$this->collUsuarisllistess = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUsuarisllistess collection (array).
	 *
	 * By default this just sets the collUsuarisllistess collection to an empty array (like clearcollUsuarisllistess());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUsuarisllistess()
	{
		$this->collUsuarisllistess = array();
	}

	/**
	 * Gets an array of Usuarisllistes objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Llistes has previously been saved, it will retrieve
	 * related Usuarisllistess from storage. If this Llistes is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Usuarisllistes[]
	 * @throws     PropelException
	 */
	public function getUsuarisllistess($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsuarisllistess === null) {
			if ($this->isNew()) {
			   $this->collUsuarisllistess = array();
			} else {

				$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				UsuarisllistesPeer::addSelectColumns($criteria);
				$this->collUsuarisllistess = UsuarisllistesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				UsuarisllistesPeer::addSelectColumns($criteria);
				if (!isset($this->lastUsuarisllistesCriteria) || !$this->lastUsuarisllistesCriteria->equals($criteria)) {
					$this->collUsuarisllistess = UsuarisllistesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUsuarisllistesCriteria = $criteria;
		return $this->collUsuarisllistess;
	}

	/**
	 * Returns the number of related Usuarisllistes objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Usuarisllistes objects.
	 * @throws     PropelException
	 */
	public function countUsuarisllistess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUsuarisllistess === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				$count = UsuarisllistesPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				if (!isset($this->lastUsuarisllistesCriteria) || !$this->lastUsuarisllistesCriteria->equals($criteria)) {
					$count = UsuarisllistesPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collUsuarisllistess);
				}
			} else {
				$count = count($this->collUsuarisllistess);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Usuarisllistes object to this object
	 * through the Usuarisllistes foreign key attribute.
	 *
	 * @param      Usuarisllistes $l Usuarisllistes
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUsuarisllistes(Usuarisllistes $l)
	{
		if ($this->collUsuarisllistess === null) {
			$this->initUsuarisllistess();
		}
		if (!in_array($l, $this->collUsuarisllistess, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUsuarisllistess, $l);
			$l->setLlistes($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Llistes is new, it will return
	 * an empty collection; or if this Llistes has previously
	 * been saved, it will retrieve related Usuarisllistess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Llistes.
	 */
	public function getUsuarisllistessJoinUsuaris($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(LlistesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsuarisllistess === null) {
			if ($this->isNew()) {
				$this->collUsuarisllistess = array();
			} else {

				$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

				$this->collUsuarisllistess = UsuarisllistesPeer::doSelectJoinUsuaris($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UsuarisllistesPeer::LLISTES_IDLLISTES, $this->idllistes);

			if (!isset($this->lastUsuarisllistesCriteria) || !$this->lastUsuarisllistesCriteria->equals($criteria)) {
				$this->collUsuarisllistess = UsuarisllistesPeer::doSelectJoinUsuaris($criteria, $con, $join_behavior);
			}
		}
		$this->lastUsuarisllistesCriteria = $criteria;

		return $this->collUsuarisllistess;
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
			if ($this->collMissatgesllistess) {
				foreach ((array) $this->collMissatgesllistess as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUsuarisllistess) {
				foreach ((array) $this->collUsuarisllistess as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collMissatgesllistess = null;
		$this->collUsuarisllistess = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseLlistes:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseLlistes::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseLlistes
