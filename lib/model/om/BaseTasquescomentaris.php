<?php

/**
 * Base class that represents a row from the 'tasquescomentaris' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Mon Oct 19 14:19:06 2009
 *
 * @package    lib.model.om
 */
abstract class BaseTasquescomentaris extends BaseObject  implements Persistent {


  const PEER = 'TasquescomentarisPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        TasquescomentarisPeer
	 */
	protected static $peer;

	/**
	 * The value for the idtasquescomentaris field.
	 * @var        int
	 */
	protected $idtasquescomentaris;

	/**
	 * The value for the tasques_tasquesid field.
	 * @var        int
	 */
	protected $tasques_tasquesid;

	/**
	 * The value for the comentari field.
	 * @var        string
	 */
	protected $comentari;

	/**
	 * The value for the data_2 field.
	 * @var        string
	 */
	protected $data_2;

	/**
	 * @var        Tasques
	 */
	protected $aTasques;

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
	 * Initializes internal state of BaseTasquescomentaris object.
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
	 * Get the [idtasquescomentaris] column value.
	 * 
	 * @return     int
	 */
	public function getIdtasquescomentaris()
	{
		return $this->idtasquescomentaris;
	}

	/**
	 * Get the [tasques_tasquesid] column value.
	 * 
	 * @return     int
	 */
	public function getTasquesTasquesid()
	{
		return $this->tasques_tasquesid;
	}

	/**
	 * Get the [comentari] column value.
	 * 
	 * @return     string
	 */
	public function getComentari()
	{
		return $this->comentari;
	}

	/**
	 * Get the [optionally formatted] temporal [data_2] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getData2($format = 'Y-m-d')
	{
		if ($this->data_2 === null) {
			return null;
		}


		if ($this->data_2 === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->data_2);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->data_2, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [idtasquescomentaris] column.
	 * 
	 * @param      int $v new value
	 * @return     Tasquescomentaris The current object (for fluent API support)
	 */
	public function setIdtasquescomentaris($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idtasquescomentaris !== $v) {
			$this->idtasquescomentaris = $v;
			$this->modifiedColumns[] = TasquescomentarisPeer::IDTASQUESCOMENTARIS;
		}

		return $this;
	} // setIdtasquescomentaris()

	/**
	 * Set the value of [tasques_tasquesid] column.
	 * 
	 * @param      int $v new value
	 * @return     Tasquescomentaris The current object (for fluent API support)
	 */
	public function setTasquesTasquesid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tasques_tasquesid !== $v) {
			$this->tasques_tasquesid = $v;
			$this->modifiedColumns[] = TasquescomentarisPeer::TASQUES_TASQUESID;
		}

		if ($this->aTasques !== null && $this->aTasques->getTasquesid() !== $v) {
			$this->aTasques = null;
		}

		return $this;
	} // setTasquesTasquesid()

	/**
	 * Set the value of [comentari] column.
	 * 
	 * @param      string $v new value
	 * @return     Tasquescomentaris The current object (for fluent API support)
	 */
	public function setComentari($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->comentari !== $v) {
			$this->comentari = $v;
			$this->modifiedColumns[] = TasquescomentarisPeer::COMENTARI;
		}

		return $this;
	} // setComentari()

	/**
	 * Sets the value of [data_2] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Tasquescomentaris The current object (for fluent API support)
	 */
	public function setData2($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->data_2 !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->data_2 !== null && $tmpDt = new DateTime($this->data_2)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->data_2 = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = TasquescomentarisPeer::DATA_2;
			}
		} // if either are not null

		return $this;
	} // setData2()

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

			$this->idtasquescomentaris = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->tasques_tasquesid = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->comentari = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->data_2 = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = TasquescomentarisPeer::NUM_COLUMNS - TasquescomentarisPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Tasquescomentaris object", $e);
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

		if ($this->aTasques !== null && $this->tasques_tasquesid !== $this->aTasques->getTasquesid()) {
			$this->aTasques = null;
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
			$con = Propel::getConnection(TasquescomentarisPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = TasquescomentarisPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aTasques = null;
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

    foreach (sfMixer::getCallables('BaseTasquescomentaris:delete:pre') as $callable)
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
			$con = Propel::getConnection(TasquescomentarisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			TasquescomentarisPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTasquescomentaris:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseTasquescomentaris:save:pre') as $callable)
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
			$con = Propel::getConnection(TasquescomentarisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTasquescomentaris:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			TasquescomentarisPeer::addInstanceToPool($this);
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

			if ($this->aTasques !== null) {
				if ($this->aTasques->isModified() || $this->aTasques->isNew()) {
					$affectedRows += $this->aTasques->save($con);
				}
				$this->setTasques($this->aTasques);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = TasquescomentarisPeer::IDTASQUESCOMENTARIS;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TasquescomentarisPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdtasquescomentaris($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += TasquescomentarisPeer::doUpdate($this, $con);
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

			if ($this->aTasques !== null) {
				if (!$this->aTasques->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTasques->getValidationFailures());
				}
			}


			if (($retval = TasquescomentarisPeer::doValidate($this, $columns)) !== true) {
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
		$pos = TasquescomentarisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdtasquescomentaris();
				break;
			case 1:
				return $this->getTasquesTasquesid();
				break;
			case 2:
				return $this->getComentari();
				break;
			case 3:
				return $this->getData2();
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
		$keys = TasquescomentarisPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdtasquescomentaris(),
			$keys[1] => $this->getTasquesTasquesid(),
			$keys[2] => $this->getComentari(),
			$keys[3] => $this->getData2(),
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
		$pos = TasquescomentarisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdtasquescomentaris($value);
				break;
			case 1:
				$this->setTasquesTasquesid($value);
				break;
			case 2:
				$this->setComentari($value);
				break;
			case 3:
				$this->setData2($value);
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
		$keys = TasquescomentarisPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdtasquescomentaris($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTasquesTasquesid($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setComentari($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData2($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(TasquescomentarisPeer::DATABASE_NAME);

		if ($this->isColumnModified(TasquescomentarisPeer::IDTASQUESCOMENTARIS)) $criteria->add(TasquescomentarisPeer::IDTASQUESCOMENTARIS, $this->idtasquescomentaris);
		if ($this->isColumnModified(TasquescomentarisPeer::TASQUES_TASQUESID)) $criteria->add(TasquescomentarisPeer::TASQUES_TASQUESID, $this->tasques_tasquesid);
		if ($this->isColumnModified(TasquescomentarisPeer::COMENTARI)) $criteria->add(TasquescomentarisPeer::COMENTARI, $this->comentari);
		if ($this->isColumnModified(TasquescomentarisPeer::DATA_2)) $criteria->add(TasquescomentarisPeer::DATA_2, $this->data_2);

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
		$criteria = new Criteria(TasquescomentarisPeer::DATABASE_NAME);

		$criteria->add(TasquescomentarisPeer::IDTASQUESCOMENTARIS, $this->idtasquescomentaris);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdtasquescomentaris();
	}

	/**
	 * Generic method to set the primary key (idtasquescomentaris column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdtasquescomentaris($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Tasquescomentaris (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTasquesTasquesid($this->tasques_tasquesid);

		$copyObj->setComentari($this->comentari);

		$copyObj->setData2($this->data_2);


		$copyObj->setNew(true);

		$copyObj->setIdtasquescomentaris(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Tasquescomentaris Clone of current object.
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
	 * @return     TasquescomentarisPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new TasquescomentarisPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Tasques object.
	 *
	 * @param      Tasques $v
	 * @return     Tasquescomentaris The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setTasques(Tasques $v = null)
	{
		if ($v === null) {
			$this->setTasquesTasquesid(NULL);
		} else {
			$this->setTasquesTasquesid($v->getTasquesid());
		}

		$this->aTasques = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Tasques object, it will not be re-added.
		if ($v !== null) {
			$v->addTasquescomentaris($this);
		}

		return $this;
	}


	/**
	 * Get the associated Tasques object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Tasques The associated Tasques object.
	 * @throws     PropelException
	 */
	public function getTasques(PropelPDO $con = null)
	{
		if ($this->aTasques === null && ($this->tasques_tasquesid !== null)) {
			$c = new Criteria(TasquesPeer::DATABASE_NAME);
			$c->add(TasquesPeer::TASQUESID, $this->tasques_tasquesid);
			$this->aTasques = TasquesPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aTasques->addTasquescomentariss($this);
			 */
		}
		return $this->aTasques;
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

			$this->aTasques = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTasquescomentaris:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTasquescomentaris::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseTasquescomentaris
