<?php

/**
 * Base class that represents a row from the 'missatgesmailing' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Feb 23 14:11:58 2010
 *
 * @package    lib.model.om
 */
abstract class BaseMissatgesmailing extends BaseObject  implements Persistent {


  const PEER = 'MissatgesmailingPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        MissatgesmailingPeer
	 */
	protected static $peer;

	/**
	 * The value for the idmissatge field.
	 * @var        int
	 */
	protected $idmissatge;

	/**
	 * The value for the titol field.
	 * @var        string
	 */
	protected $titol;

	/**
	 * The value for the text field.
	 * @var        string
	 */
	protected $text;

	/**
	 * The value for the data_alta field.
	 * @var        string
	 */
	protected $data_alta;

	/**
	 * @var        array Missatgesllistes[] Collection to store aggregation of Missatgesllistes objects.
	 */
	protected $collMissatgesllistess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collMissatgesllistess.
	 */
	private $lastMissatgesllistesCriteria = null;

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
	 * Initializes internal state of BaseMissatgesmailing object.
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
	 * Get the [idmissatge] column value.
	 * 
	 * @return     int
	 */
	public function getIdmissatge()
	{
		return $this->idmissatge;
	}

	/**
	 * Get the [titol] column value.
	 * 
	 * @return     string
	 */
	public function getTitol()
	{
		return $this->titol;
	}

	/**
	 * Get the [text] column value.
	 * 
	 * @return     string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * Get the [optionally formatted] temporal [data_alta] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDataAlta($format = 'Y-m-d')
	{
		if ($this->data_alta === null) {
			return null;
		}


		if ($this->data_alta === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->data_alta);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->data_alta, true), $x);
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
	 * Set the value of [idmissatge] column.
	 * 
	 * @param      int $v new value
	 * @return     Missatgesmailing The current object (for fluent API support)
	 */
	public function setIdmissatge($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->idmissatge !== $v) {
			$this->idmissatge = $v;
			$this->modifiedColumns[] = MissatgesmailingPeer::IDMISSATGE;
		}

		return $this;
	} // setIdmissatge()

	/**
	 * Set the value of [titol] column.
	 * 
	 * @param      string $v new value
	 * @return     Missatgesmailing The current object (for fluent API support)
	 */
	public function setTitol($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->titol !== $v) {
			$this->titol = $v;
			$this->modifiedColumns[] = MissatgesmailingPeer::TITOL;
		}

		return $this;
	} // setTitol()

	/**
	 * Set the value of [text] column.
	 * 
	 * @param      string $v new value
	 * @return     Missatgesmailing The current object (for fluent API support)
	 */
	public function setText($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->text !== $v) {
			$this->text = $v;
			$this->modifiedColumns[] = MissatgesmailingPeer::TEXT;
		}

		return $this;
	} // setText()

	/**
	 * Sets the value of [data_alta] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Missatgesmailing The current object (for fluent API support)
	 */
	public function setDataAlta($v)
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

		if ( $this->data_alta !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->data_alta !== null && $tmpDt = new DateTime($this->data_alta)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->data_alta = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = MissatgesmailingPeer::DATA_ALTA;
			}
		} // if either are not null

		return $this;
	} // setDataAlta()

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

			$this->idmissatge = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->titol = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->text = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->data_alta = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = MissatgesmailingPeer::NUM_COLUMNS - MissatgesmailingPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Missatgesmailing object", $e);
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
			$con = Propel::getConnection(MissatgesmailingPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = MissatgesmailingPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collMissatgesllistess = null;
			$this->lastMissatgesllistesCriteria = null;

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

    foreach (sfMixer::getCallables('BaseMissatgesmailing:delete:pre') as $callable)
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
			$con = Propel::getConnection(MissatgesmailingPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			MissatgesmailingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMissatgesmailing:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseMissatgesmailing:save:pre') as $callable)
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
			$con = Propel::getConnection(MissatgesmailingPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMissatgesmailing:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			MissatgesmailingPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = MissatgesmailingPeer::IDMISSATGE;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MissatgesmailingPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdmissatge($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += MissatgesmailingPeer::doUpdate($this, $con);
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


			if (($retval = MissatgesmailingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMissatgesllistess !== null) {
					foreach ($this->collMissatgesllistess as $referrerFK) {
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
		$pos = MissatgesmailingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdmissatge();
				break;
			case 1:
				return $this->getTitol();
				break;
			case 2:
				return $this->getText();
				break;
			case 3:
				return $this->getDataAlta();
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
		$keys = MissatgesmailingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdmissatge(),
			$keys[1] => $this->getTitol(),
			$keys[2] => $this->getText(),
			$keys[3] => $this->getDataAlta(),
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
		$pos = MissatgesmailingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdmissatge($value);
				break;
			case 1:
				$this->setTitol($value);
				break;
			case 2:
				$this->setText($value);
				break;
			case 3:
				$this->setDataAlta($value);
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
		$keys = MissatgesmailingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdmissatge($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitol($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setText($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDataAlta($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(MissatgesmailingPeer::DATABASE_NAME);

		if ($this->isColumnModified(MissatgesmailingPeer::IDMISSATGE)) $criteria->add(MissatgesmailingPeer::IDMISSATGE, $this->idmissatge);
		if ($this->isColumnModified(MissatgesmailingPeer::TITOL)) $criteria->add(MissatgesmailingPeer::TITOL, $this->titol);
		if ($this->isColumnModified(MissatgesmailingPeer::TEXT)) $criteria->add(MissatgesmailingPeer::TEXT, $this->text);
		if ($this->isColumnModified(MissatgesmailingPeer::DATA_ALTA)) $criteria->add(MissatgesmailingPeer::DATA_ALTA, $this->data_alta);

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
		$criteria = new Criteria(MissatgesmailingPeer::DATABASE_NAME);

		$criteria->add(MissatgesmailingPeer::IDMISSATGE, $this->idmissatge);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdmissatge();
	}

	/**
	 * Generic method to set the primary key (idmissatge column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdmissatge($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Missatgesmailing (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitol($this->titol);

		$copyObj->setText($this->text);

		$copyObj->setDataAlta($this->data_alta);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getMissatgesllistess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addMissatgesllistes($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setIdmissatge(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Missatgesmailing Clone of current object.
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
	 * @return     MissatgesmailingPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new MissatgesmailingPeer();
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
	 * Otherwise if this Missatgesmailing has previously been saved, it will retrieve
	 * related Missatgesllistess from storage. If this Missatgesmailing is new, it will return
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
			$criteria = new Criteria(MissatgesmailingPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMissatgesllistess === null) {
			if ($this->isNew()) {
			   $this->collMissatgesllistess = array();
			} else {

				$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

				MissatgesllistesPeer::addSelectColumns($criteria);
				$this->collMissatgesllistess = MissatgesllistesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

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
			$criteria = new Criteria(MissatgesmailingPeer::DATABASE_NAME);
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

				$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

				$count = MissatgesllistesPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

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
			$l->setMissatgesmailing($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Missatgesmailing is new, it will return
	 * an empty collection; or if this Missatgesmailing has previously
	 * been saved, it will retrieve related Missatgesllistess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Missatgesmailing.
	 */
	public function getMissatgesllistessJoinLlistes($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(MissatgesmailingPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMissatgesllistess === null) {
			if ($this->isNew()) {
				$this->collMissatgesllistess = array();
			} else {

				$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

				$this->collMissatgesllistess = MissatgesllistesPeer::doSelectJoinLlistes($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(MissatgesllistesPeer::IDMISSATGESLLISTES, $this->idmissatge);

			if (!isset($this->lastMissatgesllistesCriteria) || !$this->lastMissatgesllistesCriteria->equals($criteria)) {
				$this->collMissatgesllistess = MissatgesllistesPeer::doSelectJoinLlistes($criteria, $con, $join_behavior);
			}
		}
		$this->lastMissatgesllistesCriteria = $criteria;

		return $this->collMissatgesllistess;
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
		} // if ($deep)

		$this->collMissatgesllistess = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseMissatgesmailing:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMissatgesmailing::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseMissatgesmailing
