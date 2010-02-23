<?php

/**
 * Base class that represents a row from the 'app_documents_permisos_dir' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Feb 23 14:11:57 2010
 *
 * @package    lib.model.om
 */
abstract class BaseAppDocumentsPermisosDir extends BaseObject  implements Persistent {


  const PEER = 'AppDocumentsPermisosDirPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AppDocumentsPermisosDirPeer
	 */
	protected static $peer;

	/**
	 * The value for the idusuari field.
	 * @var        int
	 */
	protected $idusuari;

	/**
	 * The value for the iddirectori field.
	 * @var        int
	 */
	protected $iddirectori;

	/**
	 * The value for the idnivell field.
	 * @var        int
	 */
	protected $idnivell;

	/**
	 * @var        Usuaris
	 */
	protected $aUsuaris;

	/**
	 * @var        AppDocumentsDirectoris
	 */
	protected $aAppDocumentsDirectoris;

	/**
	 * @var        Nivells
	 */
	protected $aNivells;

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
	 * Initializes internal state of BaseAppDocumentsPermisosDir object.
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
	 * Get the [idusuari] column value.
	 * 
	 * @return     int
	 */
	public function getIdusuari()
	{
		return $this->idusuari;
	}

	/**
	 * Get the [iddirectori] column value.
	 * 
	 * @return     int
	 */
	public function getIddirectori()
	{
		return $this->iddirectori;
	}

	/**
	 * Get the [idnivell] column value.
	 * 
	 * @return     int
	 */
	public function getIdnivell()
	{
		return $this->idnivell;
	}

	/**
	 * Set the value of [idusuari] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 */
	public function setIdusuari($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idusuari !== $v) {
			$this->idusuari = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosDirPeer::IDUSUARI;
		}

		if ($this->aUsuaris !== null && $this->aUsuaris->getUsuariid() !== $v) {
			$this->aUsuaris = null;
		}

		return $this;
	} // setIdusuari()

	/**
	 * Set the value of [iddirectori] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 */
	public function setIddirectori($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->iddirectori !== $v) {
			$this->iddirectori = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosDirPeer::IDDIRECTORI;
		}

		if ($this->aAppDocumentsDirectoris !== null && $this->aAppDocumentsDirectoris->getIddirectori() !== $v) {
			$this->aAppDocumentsDirectoris = null;
		}

		return $this;
	} // setIddirectori()

	/**
	 * Set the value of [idnivell] column.
	 * 
	 * @param      int $v new value
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 */
	public function setIdnivell($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idnivell !== $v) {
			$this->idnivell = $v;
			$this->modifiedColumns[] = AppDocumentsPermisosDirPeer::IDNIVELL;
		}

		if ($this->aNivells !== null && $this->aNivells->getIdnivells() !== $v) {
			$this->aNivells = null;
		}

		return $this;
	} // setIdnivell()

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

			$this->idusuari = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->iddirectori = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->idnivell = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = AppDocumentsPermisosDirPeer::NUM_COLUMNS - AppDocumentsPermisosDirPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating AppDocumentsPermisosDir object", $e);
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

		if ($this->aUsuaris !== null && $this->idusuari !== $this->aUsuaris->getUsuariid()) {
			$this->aUsuaris = null;
		}
		if ($this->aAppDocumentsDirectoris !== null && $this->iddirectori !== $this->aAppDocumentsDirectoris->getIddirectori()) {
			$this->aAppDocumentsDirectoris = null;
		}
		if ($this->aNivells !== null && $this->idnivell !== $this->aNivells->getIdnivells()) {
			$this->aNivells = null;
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
			$con = Propel::getConnection(AppDocumentsPermisosDirPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = AppDocumentsPermisosDirPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUsuaris = null;
			$this->aAppDocumentsDirectoris = null;
			$this->aNivells = null;
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

    foreach (sfMixer::getCallables('BaseAppDocumentsPermisosDir:delete:pre') as $callable)
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
			$con = Propel::getConnection(AppDocumentsPermisosDirPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			AppDocumentsPermisosDirPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseAppDocumentsPermisosDir:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseAppDocumentsPermisosDir:save:pre') as $callable)
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
			$con = Propel::getConnection(AppDocumentsPermisosDirPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseAppDocumentsPermisosDir:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			AppDocumentsPermisosDirPeer::addInstanceToPool($this);
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

			if ($this->aUsuaris !== null) {
				if ($this->aUsuaris->isModified() || $this->aUsuaris->isNew()) {
					$affectedRows += $this->aUsuaris->save($con);
				}
				$this->setUsuaris($this->aUsuaris);
			}

			if ($this->aAppDocumentsDirectoris !== null) {
				if ($this->aAppDocumentsDirectoris->isModified() || $this->aAppDocumentsDirectoris->isNew()) {
					$affectedRows += $this->aAppDocumentsDirectoris->save($con);
				}
				$this->setAppDocumentsDirectoris($this->aAppDocumentsDirectoris);
			}

			if ($this->aNivells !== null) {
				if ($this->aNivells->isModified() || $this->aNivells->isNew()) {
					$affectedRows += $this->aNivells->save($con);
				}
				$this->setNivells($this->aNivells);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AppDocumentsPermisosDirPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += AppDocumentsPermisosDirPeer::doUpdate($this, $con);
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


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aUsuaris !== null) {
				if (!$this->aUsuaris->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUsuaris->getValidationFailures());
				}
			}

			if ($this->aAppDocumentsDirectoris !== null) {
				if (!$this->aAppDocumentsDirectoris->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAppDocumentsDirectoris->getValidationFailures());
				}
			}

			if ($this->aNivells !== null) {
				if (!$this->aNivells->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aNivells->getValidationFailures());
				}
			}


			if (($retval = AppDocumentsPermisosDirPeer::doValidate($this, $columns)) !== true) {
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
		$pos = AppDocumentsPermisosDirPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdusuari();
				break;
			case 1:
				return $this->getIddirectori();
				break;
			case 2:
				return $this->getIdnivell();
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
		$keys = AppDocumentsPermisosDirPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdusuari(),
			$keys[1] => $this->getIddirectori(),
			$keys[2] => $this->getIdnivell(),
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
		$pos = AppDocumentsPermisosDirPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdusuari($value);
				break;
			case 1:
				$this->setIddirectori($value);
				break;
			case 2:
				$this->setIdnivell($value);
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
		$keys = AppDocumentsPermisosDirPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdusuari($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIddirectori($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIdnivell($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AppDocumentsPermisosDirPeer::DATABASE_NAME);

		if ($this->isColumnModified(AppDocumentsPermisosDirPeer::IDUSUARI)) $criteria->add(AppDocumentsPermisosDirPeer::IDUSUARI, $this->idusuari);
		if ($this->isColumnModified(AppDocumentsPermisosDirPeer::IDDIRECTORI)) $criteria->add(AppDocumentsPermisosDirPeer::IDDIRECTORI, $this->iddirectori);
		if ($this->isColumnModified(AppDocumentsPermisosDirPeer::IDNIVELL)) $criteria->add(AppDocumentsPermisosDirPeer::IDNIVELL, $this->idnivell);

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
		$criteria = new Criteria(AppDocumentsPermisosDirPeer::DATABASE_NAME);

		$criteria->add(AppDocumentsPermisosDirPeer::IDUSUARI, $this->idusuari);
		$criteria->add(AppDocumentsPermisosDirPeer::IDDIRECTORI, $this->iddirectori);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getIdusuari();

		$pks[1] = $this->getIddirectori();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setIdusuari($keys[0]);

		$this->setIddirectori($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of AppDocumentsPermisosDir (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIdusuari($this->idusuari);

		$copyObj->setIddirectori($this->iddirectori);

		$copyObj->setIdnivell($this->idnivell);


		$copyObj->setNew(true);

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
	 * @return     AppDocumentsPermisosDir Clone of current object.
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
	 * @return     AppDocumentsPermisosDirPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AppDocumentsPermisosDirPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Usuaris object.
	 *
	 * @param      Usuaris $v
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUsuaris(Usuaris $v = null)
	{
		if ($v === null) {
			$this->setIdusuari(NULL);
		} else {
			$this->setIdusuari($v->getUsuariid());
		}

		$this->aUsuaris = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Usuaris object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisosDir($this);
		}

		return $this;
	}


	/**
	 * Get the associated Usuaris object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Usuaris The associated Usuaris object.
	 * @throws     PropelException
	 */
	public function getUsuaris(PropelPDO $con = null)
	{
		if ($this->aUsuaris === null && ($this->idusuari !== null)) {
			$c = new Criteria(UsuarisPeer::DATABASE_NAME);
			$c->add(UsuarisPeer::USUARIID, $this->idusuari);
			$this->aUsuaris = UsuarisPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUsuaris->addAppDocumentsPermisosDirs($this);
			 */
		}
		return $this->aUsuaris;
	}

	/**
	 * Declares an association between this object and a AppDocumentsDirectoris object.
	 *
	 * @param      AppDocumentsDirectoris $v
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setAppDocumentsDirectoris(AppDocumentsDirectoris $v = null)
	{
		if ($v === null) {
			$this->setIddirectori(NULL);
		} else {
			$this->setIddirectori($v->getIddirectori());
		}

		$this->aAppDocumentsDirectoris = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the AppDocumentsDirectoris object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisosDir($this);
		}

		return $this;
	}


	/**
	 * Get the associated AppDocumentsDirectoris object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     AppDocumentsDirectoris The associated AppDocumentsDirectoris object.
	 * @throws     PropelException
	 */
	public function getAppDocumentsDirectoris(PropelPDO $con = null)
	{
		if ($this->aAppDocumentsDirectoris === null && ($this->iddirectori !== null)) {
			$c = new Criteria(AppDocumentsDirectorisPeer::DATABASE_NAME);
			$c->add(AppDocumentsDirectorisPeer::IDDIRECTORI, $this->iddirectori);
			$this->aAppDocumentsDirectoris = AppDocumentsDirectorisPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aAppDocumentsDirectoris->addAppDocumentsPermisosDirs($this);
			 */
		}
		return $this->aAppDocumentsDirectoris;
	}

	/**
	 * Declares an association between this object and a Nivells object.
	 *
	 * @param      Nivells $v
	 * @return     AppDocumentsPermisosDir The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setNivells(Nivells $v = null)
	{
		if ($v === null) {
			$this->setIdnivell(NULL);
		} else {
			$this->setIdnivell($v->getIdnivells());
		}

		$this->aNivells = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Nivells object, it will not be re-added.
		if ($v !== null) {
			$v->addAppDocumentsPermisosDir($this);
		}

		return $this;
	}


	/**
	 * Get the associated Nivells object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Nivells The associated Nivells object.
	 * @throws     PropelException
	 */
	public function getNivells(PropelPDO $con = null)
	{
		if ($this->aNivells === null && ($this->idnivell !== null)) {
			$c = new Criteria(NivellsPeer::DATABASE_NAME);
			$c->add(NivellsPeer::IDNIVELLS, $this->idnivell);
			$this->aNivells = NivellsPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aNivells->addAppDocumentsPermisosDirs($this);
			 */
		}
		return $this->aNivells;
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

			$this->aUsuaris = null;
			$this->aAppDocumentsDirectoris = null;
			$this->aNivells = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseAppDocumentsPermisosDir:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseAppDocumentsPermisosDir::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseAppDocumentsPermisosDir
