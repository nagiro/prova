<?php

/**
 * Base class that represents a row from the 'agendatelefonica' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/12/12 12:13:21
 *
 * @package    lib.model.om
 */
abstract class BaseAgendatelefonica extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AgendatelefonicaPeer
	 */
	protected static $peer;

	/**
	 * The value for the agendatelefonicaid field.
	 * @var        int
	 */
	protected $agendatelefonicaid;

	/**
	 * The value for the nom field.
	 * @var        string
	 */
	protected $nom;

	/**
	 * The value for the nif field.
	 * @var        string
	 */
	protected $nif;

	/**
	 * The value for the dataalta field.
	 * @var        string
	 */
	protected $dataalta;

	/**
	 * The value for the notes field.
	 * @var        string
	 */
	protected $notes;

	/**
	 * The value for the tags field.
	 * @var        string
	 */
	protected $tags;

	/**
	 * The value for the entitat field.
	 * @var        string
	 */
	protected $entitat;

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
	 * @var        array Agendatelefonicadades[] Collection to store aggregation of Agendatelefonicadades objects.
	 */
	protected $collAgendatelefonicadadess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAgendatelefonicadadess.
	 */
	private $lastAgendatelefonicadadesCriteria = null;

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
	
	const PEER = 'AgendatelefonicaPeer';

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
	 * Initializes internal state of BaseAgendatelefonica object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [agendatelefonicaid] column value.
	 * 
	 * @return     int
	 */
	public function getAgendatelefonicaid()
	{
		return $this->agendatelefonicaid;
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
	 * Get the [nif] column value.
	 * 
	 * @return     string
	 */
	public function getNif()
	{
		return $this->nif;
	}

	/**
	 * Get the [optionally formatted] temporal [dataalta] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getDataalta($format = 'Y-m-d')
	{
		if ($this->dataalta === null) {
			return null;
		}


		if ($this->dataalta === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->dataalta);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->dataalta, true), $x);
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
	 * Get the [notes] column value.
	 * 
	 * @return     string
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Get the [tags] column value.
	 * 
	 * @return     string
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Get the [entitat] column value.
	 * 
	 * @return     string
	 */
	public function getEntitat()
	{
		return $this->entitat;
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
	 * Set the value of [agendatelefonicaid] column.
	 * 
	 * @param      int $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setAgendatelefonicaid($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->agendatelefonicaid !== $v) {
			$this->agendatelefonicaid = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::AGENDATELEFONICAID;
		}

		return $this;
	} // setAgendatelefonicaid()

	/**
	 * Set the value of [nom] column.
	 * 
	 * @param      string $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setNom($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom !== $v) {
			$this->nom = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::NOM;
		}

		return $this;
	} // setNom()

	/**
	 * Set the value of [nif] column.
	 * 
	 * @param      string $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setNif($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nif !== $v) {
			$this->nif = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::NIF;
		}

		return $this;
	} // setNif()

	/**
	 * Sets the value of [dataalta] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setDataalta($v)
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

		if ( $this->dataalta !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->dataalta !== null && $tmpDt = new DateTime($this->dataalta)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->dataalta = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = AgendatelefonicaPeer::DATAALTA;
			}
		} // if either are not null

		return $this;
	} // setDataalta()

	/**
	 * Set the value of [notes] column.
	 * 
	 * @param      string $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setNotes($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->notes !== $v) {
			$this->notes = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::NOTES;
		}

		return $this;
	} // setNotes()

	/**
	 * Set the value of [tags] column.
	 * 
	 * @param      string $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setTags($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tags !== $v) {
			$this->tags = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::TAGS;
		}

		return $this;
	} // setTags()

	/**
	 * Set the value of [entitat] column.
	 * 
	 * @param      string $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setEntitat($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->entitat !== $v) {
			$this->entitat = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::ENTITAT;
		}

		return $this;
	} // setEntitat()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v || $this->isNew()) {
			$this->site_id = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     Agendatelefonica The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = AgendatelefonicaPeer::ACTIU;
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

			$this->agendatelefonicaid = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->nom = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->nif = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->dataalta = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->notes = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->tags = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->entitat = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->site_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->actiu = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 9; // 9 = AgendatelefonicaPeer::NUM_COLUMNS - AgendatelefonicaPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Agendatelefonica object", $e);
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
			$con = Propel::getConnection(AgendatelefonicaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = AgendatelefonicaPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collAgendatelefonicadadess = null;
			$this->lastAgendatelefonicadadesCriteria = null;

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
			$con = Propel::getConnection(AgendatelefonicaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAgendatelefonica:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				AgendatelefonicaPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseAgendatelefonica:delete:post') as $callable)
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
			$con = Propel::getConnection(AgendatelefonicaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAgendatelefonica:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseAgendatelefonica:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				AgendatelefonicaPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = AgendatelefonicaPeer::AGENDATELEFONICAID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AgendatelefonicaPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setAgendatelefonicaid($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += AgendatelefonicaPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collAgendatelefonicadadess !== null) {
				foreach ($this->collAgendatelefonicadadess as $referrerFK) {
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


			if (($retval = AgendatelefonicaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAgendatelefonicadadess !== null) {
					foreach ($this->collAgendatelefonicadadess as $referrerFK) {
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
		$pos = AgendatelefonicaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getAgendatelefonicaid();
				break;
			case 1:
				return $this->getNom();
				break;
			case 2:
				return $this->getNif();
				break;
			case 3:
				return $this->getDataalta();
				break;
			case 4:
				return $this->getNotes();
				break;
			case 5:
				return $this->getTags();
				break;
			case 6:
				return $this->getEntitat();
				break;
			case 7:
				return $this->getSiteId();
				break;
			case 8:
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
		$keys = AgendatelefonicaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAgendatelefonicaid(),
			$keys[1] => $this->getNom(),
			$keys[2] => $this->getNif(),
			$keys[3] => $this->getDataalta(),
			$keys[4] => $this->getNotes(),
			$keys[5] => $this->getTags(),
			$keys[6] => $this->getEntitat(),
			$keys[7] => $this->getSiteId(),
			$keys[8] => $this->getActiu(),
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
		$pos = AgendatelefonicaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setAgendatelefonicaid($value);
				break;
			case 1:
				$this->setNom($value);
				break;
			case 2:
				$this->setNif($value);
				break;
			case 3:
				$this->setDataalta($value);
				break;
			case 4:
				$this->setNotes($value);
				break;
			case 5:
				$this->setTags($value);
				break;
			case 6:
				$this->setEntitat($value);
				break;
			case 7:
				$this->setSiteId($value);
				break;
			case 8:
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
		$keys = AgendatelefonicaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAgendatelefonicaid($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNom($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNif($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDataalta($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNotes($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTags($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setEntitat($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setSiteId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setActiu($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AgendatelefonicaPeer::DATABASE_NAME);

		if ($this->isColumnModified(AgendatelefonicaPeer::AGENDATELEFONICAID)) $criteria->add(AgendatelefonicaPeer::AGENDATELEFONICAID, $this->agendatelefonicaid);
		if ($this->isColumnModified(AgendatelefonicaPeer::NOM)) $criteria->add(AgendatelefonicaPeer::NOM, $this->nom);
		if ($this->isColumnModified(AgendatelefonicaPeer::NIF)) $criteria->add(AgendatelefonicaPeer::NIF, $this->nif);
		if ($this->isColumnModified(AgendatelefonicaPeer::DATAALTA)) $criteria->add(AgendatelefonicaPeer::DATAALTA, $this->dataalta);
		if ($this->isColumnModified(AgendatelefonicaPeer::NOTES)) $criteria->add(AgendatelefonicaPeer::NOTES, $this->notes);
		if ($this->isColumnModified(AgendatelefonicaPeer::TAGS)) $criteria->add(AgendatelefonicaPeer::TAGS, $this->tags);
		if ($this->isColumnModified(AgendatelefonicaPeer::ENTITAT)) $criteria->add(AgendatelefonicaPeer::ENTITAT, $this->entitat);
		if ($this->isColumnModified(AgendatelefonicaPeer::SITE_ID)) $criteria->add(AgendatelefonicaPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(AgendatelefonicaPeer::ACTIU)) $criteria->add(AgendatelefonicaPeer::ACTIU, $this->actiu);

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
		$criteria = new Criteria(AgendatelefonicaPeer::DATABASE_NAME);

		$criteria->add(AgendatelefonicaPeer::AGENDATELEFONICAID, $this->agendatelefonicaid);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getAgendatelefonicaid();
	}

	/**
	 * Generic method to set the primary key (agendatelefonicaid column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setAgendatelefonicaid($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of Agendatelefonica (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNom($this->nom);

		$copyObj->setNif($this->nif);

		$copyObj->setDataalta($this->dataalta);

		$copyObj->setNotes($this->notes);

		$copyObj->setTags($this->tags);

		$copyObj->setEntitat($this->entitat);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setActiu($this->actiu);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getAgendatelefonicadadess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAgendatelefonicadades($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setAgendatelefonicaid(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     Agendatelefonica Clone of current object.
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
	 * @return     AgendatelefonicaPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AgendatelefonicaPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collAgendatelefonicadadess collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAgendatelefonicadadess()
	 */
	public function clearAgendatelefonicadadess()
	{
		$this->collAgendatelefonicadadess = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAgendatelefonicadadess collection (array).
	 *
	 * By default this just sets the collAgendatelefonicadadess collection to an empty array (like clearcollAgendatelefonicadadess());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAgendatelefonicadadess()
	{
		$this->collAgendatelefonicadadess = array();
	}

	/**
	 * Gets an array of Agendatelefonicadades objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this Agendatelefonica has previously been saved, it will retrieve
	 * related Agendatelefonicadadess from storage. If this Agendatelefonica is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Agendatelefonicadades[]
	 * @throws     PropelException
	 */
	public function getAgendatelefonicadadess($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AgendatelefonicaPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAgendatelefonicadadess === null) {
			if ($this->isNew()) {
			   $this->collAgendatelefonicadadess = array();
			} else {

				$criteria->add(AgendatelefonicadadesPeer::AGENDATELEFONICA_AGENDATELEFONICAID, $this->agendatelefonicaid);

				AgendatelefonicadadesPeer::addSelectColumns($criteria);
				$this->collAgendatelefonicadadess = AgendatelefonicadadesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AgendatelefonicadadesPeer::AGENDATELEFONICA_AGENDATELEFONICAID, $this->agendatelefonicaid);

				AgendatelefonicadadesPeer::addSelectColumns($criteria);
				if (!isset($this->lastAgendatelefonicadadesCriteria) || !$this->lastAgendatelefonicadadesCriteria->equals($criteria)) {
					$this->collAgendatelefonicadadess = AgendatelefonicadadesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAgendatelefonicadadesCriteria = $criteria;
		return $this->collAgendatelefonicadadess;
	}

	/**
	 * Returns the number of related Agendatelefonicadades objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Agendatelefonicadades objects.
	 * @throws     PropelException
	 */
	public function countAgendatelefonicadadess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AgendatelefonicaPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAgendatelefonicadadess === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AgendatelefonicadadesPeer::AGENDATELEFONICA_AGENDATELEFONICAID, $this->agendatelefonicaid);

				$count = AgendatelefonicadadesPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AgendatelefonicadadesPeer::AGENDATELEFONICA_AGENDATELEFONICAID, $this->agendatelefonicaid);

				if (!isset($this->lastAgendatelefonicadadesCriteria) || !$this->lastAgendatelefonicadadesCriteria->equals($criteria)) {
					$count = AgendatelefonicadadesPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collAgendatelefonicadadess);
				}
			} else {
				$count = count($this->collAgendatelefonicadadess);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Agendatelefonicadades object to this object
	 * through the Agendatelefonicadades foreign key attribute.
	 *
	 * @param      Agendatelefonicadades $l Agendatelefonicadades
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAgendatelefonicadades(Agendatelefonicadades $l)
	{
		if ($this->collAgendatelefonicadadess === null) {
			$this->initAgendatelefonicadadess();
		}
		if (!in_array($l, $this->collAgendatelefonicadadess, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAgendatelefonicadadess, $l);
			$l->setAgendatelefonica($this);
		}
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
			if ($this->collAgendatelefonicadadess) {
				foreach ((array) $this->collAgendatelefonicadadess as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collAgendatelefonicadadess = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseAgendatelefonica:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseAgendatelefonica::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseAgendatelefonica
