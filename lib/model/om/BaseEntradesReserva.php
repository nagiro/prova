<?php

/**
 * Base class that represents a row from the 'entrades_reserva' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 03/12/12 12:13:29
 *
 * @package    lib.model.om
 */
abstract class BaseEntradesReserva extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EntradesReservaPeer
	 */
	protected static $peer;

	/**
	 * The value for the identrada field.
	 * @var        int
	 */
	protected $identrada;

	/**
	 * The value for the entrades_preus_horari_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $entrades_preus_horari_id;

	/**
	 * The value for the entrades_preus_activitat_id field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $entrades_preus_activitat_id;

	/**
	 * The value for the usuari_id field.
	 * @var        int
	 */
	protected $usuari_id;

	/**
	 * The value for the nom_reserva field.
	 * @var        string
	 */
	protected $nom_reserva;

	/**
	 * The value for the quantitat field.
	 * @var        int
	 */
	protected $quantitat;

	/**
	 * The value for the data field.
	 * @var        string
	 */
	protected $data;

	/**
	 * The value for the estat field.
	 * @var        int
	 */
	protected $estat;

	/**
	 * The value for the actiu field.
	 * Note: this column has a database default value of: 1
	 * @var        int
	 */
	protected $actiu;

	/**
	 * The value for the site_id field.
	 * @var        int
	 */
	protected $site_id;

	/**
	 * The value for the tipus field.
	 * @var        int
	 */
	protected $tipus;

	/**
	 * The value for the descompte field.
	 * @var        int
	 */
	protected $descompte;

	/**
	 * The value for the tpv_operacio field.
	 * @var        string
	 */
	protected $tpv_operacio;

	/**
	 * The value for the tpv_order field.
	 * @var        int
	 */
	protected $tpv_order;

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
	
	const PEER = 'EntradesReservaPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->entrades_preus_horari_id = 0;
		$this->entrades_preus_activitat_id = 0;
		$this->actiu = 1;
	}

	/**
	 * Initializes internal state of BaseEntradesReserva object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [identrada] column value.
	 * 
	 * @return     int
	 */
	public function getIdentrada()
	{
		return $this->identrada;
	}

	/**
	 * Get the [entrades_preus_horari_id] column value.
	 * 
	 * @return     int
	 */
	public function getEntradesPreusHorariId()
	{
		return $this->entrades_preus_horari_id;
	}

	/**
	 * Get the [entrades_preus_activitat_id] column value.
	 * 
	 * @return     int
	 */
	public function getEntradesPreusActivitatId()
	{
		return $this->entrades_preus_activitat_id;
	}

	/**
	 * Get the [usuari_id] column value.
	 * 
	 * @return     int
	 */
	public function getUsuariId()
	{
		return $this->usuari_id;
	}

	/**
	 * Get the [nom_reserva] column value.
	 * 
	 * @return     string
	 */
	public function getNomReserva()
	{
		return $this->nom_reserva;
	}

	/**
	 * Get the [quantitat] column value.
	 * 
	 * @return     int
	 */
	public function getQuantitat()
	{
		return $this->quantitat;
	}

	/**
	 * Get the [optionally formatted] temporal [data] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getData($format = 'Y-m-d H:i:s')
	{
		if ($this->data === null) {
			return null;
		}


		if ($this->data === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->data);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->data, true), $x);
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
	 * Get the [estat] column value.
	 * 
	 * @return     int
	 */
	public function getEstat()
	{
		return $this->estat;
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
	 * Get the [site_id] column value.
	 * 
	 * @return     int
	 */
	public function getSiteId()
	{
		return $this->site_id;
	}

	/**
	 * Get the [tipus] column value.
	 * 
	 * @return     int
	 */
	public function getTipus()
	{
		return $this->tipus;
	}

	/**
	 * Get the [descompte] column value.
	 * 
	 * @return     int
	 */
	public function getDescompte()
	{
		return $this->descompte;
	}

	/**
	 * Get the [tpv_operacio] column value.
	 * 
	 * @return     string
	 */
	public function getTpvOperacio()
	{
		return $this->tpv_operacio;
	}

	/**
	 * Get the [tpv_order] column value.
	 * 
	 * @return     int
	 */
	public function getTpvOrder()
	{
		return $this->tpv_order;
	}

	/**
	 * Set the value of [identrada] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setIdentrada($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->identrada !== $v) {
			$this->identrada = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::IDENTRADA;
		}

		return $this;
	} // setIdentrada()

	/**
	 * Set the value of [entrades_preus_horari_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setEntradesPreusHorariId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->entrades_preus_horari_id !== $v || $this->isNew()) {
			$this->entrades_preus_horari_id = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::ENTRADES_PREUS_HORARI_ID;
		}

		return $this;
	} // setEntradesPreusHorariId()

	/**
	 * Set the value of [entrades_preus_activitat_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setEntradesPreusActivitatId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->entrades_preus_activitat_id !== $v || $this->isNew()) {
			$this->entrades_preus_activitat_id = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::ENTRADES_PREUS_ACTIVITAT_ID;
		}

		return $this;
	} // setEntradesPreusActivitatId()

	/**
	 * Set the value of [usuari_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setUsuariId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->usuari_id !== $v) {
			$this->usuari_id = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::USUARI_ID;
		}

		return $this;
	} // setUsuariId()

	/**
	 * Set the value of [nom_reserva] column.
	 * 
	 * @param      string $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setNomReserva($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->nom_reserva !== $v) {
			$this->nom_reserva = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::NOM_RESERVA;
		}

		return $this;
	} // setNomReserva()

	/**
	 * Set the value of [quantitat] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setQuantitat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->quantitat !== $v) {
			$this->quantitat = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::QUANTITAT;
		}

		return $this;
	} // setQuantitat()

	/**
	 * Sets the value of [data] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setData($v)
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

		if ( $this->data !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->data !== null && $tmpDt = new DateTime($this->data)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->data = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = EntradesReservaPeer::DATA;
			}
		} // if either are not null

		return $this;
	} // setData()

	/**
	 * Set the value of [estat] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setEstat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->estat !== $v) {
			$this->estat = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::ESTAT;
		}

		return $this;
	} // setEstat()

	/**
	 * Set the value of [actiu] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setActiu($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->actiu !== $v || $this->isNew()) {
			$this->actiu = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::ACTIU;
		}

		return $this;
	} // setActiu()

	/**
	 * Set the value of [site_id] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setSiteId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->site_id !== $v) {
			$this->site_id = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::SITE_ID;
		}

		return $this;
	} // setSiteId()

	/**
	 * Set the value of [tipus] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setTipus($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tipus !== $v) {
			$this->tipus = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::TIPUS;
		}

		return $this;
	} // setTipus()

	/**
	 * Set the value of [descompte] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setDescompte($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->descompte !== $v) {
			$this->descompte = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::DESCOMPTE;
		}

		return $this;
	} // setDescompte()

	/**
	 * Set the value of [tpv_operacio] column.
	 * 
	 * @param      string $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setTpvOperacio($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->tpv_operacio !== $v) {
			$this->tpv_operacio = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::TPV_OPERACIO;
		}

		return $this;
	} // setTpvOperacio()

	/**
	 * Set the value of [tpv_order] column.
	 * 
	 * @param      int $v new value
	 * @return     EntradesReserva The current object (for fluent API support)
	 */
	public function setTpvOrder($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tpv_order !== $v) {
			$this->tpv_order = $v;
			$this->modifiedColumns[] = EntradesReservaPeer::TPV_ORDER;
		}

		return $this;
	} // setTpvOrder()

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
			if ($this->entrades_preus_horari_id !== 0) {
				return false;
			}

			if ($this->entrades_preus_activitat_id !== 0) {
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

			$this->identrada = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->entrades_preus_horari_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->entrades_preus_activitat_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->usuari_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->nom_reserva = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->quantitat = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->data = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->estat = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->actiu = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->site_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->tipus = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->descompte = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
			$this->tpv_operacio = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->tpv_order = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = EntradesReservaPeer::NUM_COLUMNS - EntradesReservaPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating EntradesReserva object", $e);
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
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EntradesReservaPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntradesReserva:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EntradesReservaPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEntradesReserva:delete:post') as $callable)
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
			$con = Propel::getConnection(EntradesReservaPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEntradesReserva:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseEntradesReserva:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EntradesReservaPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = EntradesReservaPeer::IDENTRADA;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EntradesReservaPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setIdentrada($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += EntradesReservaPeer::doUpdate($this, $con);
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


			if (($retval = EntradesReservaPeer::doValidate($this, $columns)) !== true) {
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
		$pos = EntradesReservaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIdentrada();
				break;
			case 1:
				return $this->getEntradesPreusHorariId();
				break;
			case 2:
				return $this->getEntradesPreusActivitatId();
				break;
			case 3:
				return $this->getUsuariId();
				break;
			case 4:
				return $this->getNomReserva();
				break;
			case 5:
				return $this->getQuantitat();
				break;
			case 6:
				return $this->getData();
				break;
			case 7:
				return $this->getEstat();
				break;
			case 8:
				return $this->getActiu();
				break;
			case 9:
				return $this->getSiteId();
				break;
			case 10:
				return $this->getTipus();
				break;
			case 11:
				return $this->getDescompte();
				break;
			case 12:
				return $this->getTpvOperacio();
				break;
			case 13:
				return $this->getTpvOrder();
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
		$keys = EntradesReservaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdentrada(),
			$keys[1] => $this->getEntradesPreusHorariId(),
			$keys[2] => $this->getEntradesPreusActivitatId(),
			$keys[3] => $this->getUsuariId(),
			$keys[4] => $this->getNomReserva(),
			$keys[5] => $this->getQuantitat(),
			$keys[6] => $this->getData(),
			$keys[7] => $this->getEstat(),
			$keys[8] => $this->getActiu(),
			$keys[9] => $this->getSiteId(),
			$keys[10] => $this->getTipus(),
			$keys[11] => $this->getDescompte(),
			$keys[12] => $this->getTpvOperacio(),
			$keys[13] => $this->getTpvOrder(),
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
		$pos = EntradesReservaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIdentrada($value);
				break;
			case 1:
				$this->setEntradesPreusHorariId($value);
				break;
			case 2:
				$this->setEntradesPreusActivitatId($value);
				break;
			case 3:
				$this->setUsuariId($value);
				break;
			case 4:
				$this->setNomReserva($value);
				break;
			case 5:
				$this->setQuantitat($value);
				break;
			case 6:
				$this->setData($value);
				break;
			case 7:
				$this->setEstat($value);
				break;
			case 8:
				$this->setActiu($value);
				break;
			case 9:
				$this->setSiteId($value);
				break;
			case 10:
				$this->setTipus($value);
				break;
			case 11:
				$this->setDescompte($value);
				break;
			case 12:
				$this->setTpvOperacio($value);
				break;
			case 13:
				$this->setTpvOrder($value);
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
		$keys = EntradesReservaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdentrada($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEntradesPreusHorariId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEntradesPreusActivitatId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUsuariId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNomReserva($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setQuantitat($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setData($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setEstat($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setActiu($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setSiteId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setTipus($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDescompte($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setTpvOperacio($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setTpvOrder($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EntradesReservaPeer::DATABASE_NAME);

		if ($this->isColumnModified(EntradesReservaPeer::IDENTRADA)) $criteria->add(EntradesReservaPeer::IDENTRADA, $this->identrada);
		if ($this->isColumnModified(EntradesReservaPeer::ENTRADES_PREUS_HORARI_ID)) $criteria->add(EntradesReservaPeer::ENTRADES_PREUS_HORARI_ID, $this->entrades_preus_horari_id);
		if ($this->isColumnModified(EntradesReservaPeer::ENTRADES_PREUS_ACTIVITAT_ID)) $criteria->add(EntradesReservaPeer::ENTRADES_PREUS_ACTIVITAT_ID, $this->entrades_preus_activitat_id);
		if ($this->isColumnModified(EntradesReservaPeer::USUARI_ID)) $criteria->add(EntradesReservaPeer::USUARI_ID, $this->usuari_id);
		if ($this->isColumnModified(EntradesReservaPeer::NOM_RESERVA)) $criteria->add(EntradesReservaPeer::NOM_RESERVA, $this->nom_reserva);
		if ($this->isColumnModified(EntradesReservaPeer::QUANTITAT)) $criteria->add(EntradesReservaPeer::QUANTITAT, $this->quantitat);
		if ($this->isColumnModified(EntradesReservaPeer::DATA)) $criteria->add(EntradesReservaPeer::DATA, $this->data);
		if ($this->isColumnModified(EntradesReservaPeer::ESTAT)) $criteria->add(EntradesReservaPeer::ESTAT, $this->estat);
		if ($this->isColumnModified(EntradesReservaPeer::ACTIU)) $criteria->add(EntradesReservaPeer::ACTIU, $this->actiu);
		if ($this->isColumnModified(EntradesReservaPeer::SITE_ID)) $criteria->add(EntradesReservaPeer::SITE_ID, $this->site_id);
		if ($this->isColumnModified(EntradesReservaPeer::TIPUS)) $criteria->add(EntradesReservaPeer::TIPUS, $this->tipus);
		if ($this->isColumnModified(EntradesReservaPeer::DESCOMPTE)) $criteria->add(EntradesReservaPeer::DESCOMPTE, $this->descompte);
		if ($this->isColumnModified(EntradesReservaPeer::TPV_OPERACIO)) $criteria->add(EntradesReservaPeer::TPV_OPERACIO, $this->tpv_operacio);
		if ($this->isColumnModified(EntradesReservaPeer::TPV_ORDER)) $criteria->add(EntradesReservaPeer::TPV_ORDER, $this->tpv_order);

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
		$criteria = new Criteria(EntradesReservaPeer::DATABASE_NAME);

		$criteria->add(EntradesReservaPeer::IDENTRADA, $this->identrada);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getIdentrada();
	}

	/**
	 * Generic method to set the primary key (identrada column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setIdentrada($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of EntradesReserva (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setEntradesPreusHorariId($this->entrades_preus_horari_id);

		$copyObj->setEntradesPreusActivitatId($this->entrades_preus_activitat_id);

		$copyObj->setUsuariId($this->usuari_id);

		$copyObj->setNomReserva($this->nom_reserva);

		$copyObj->setQuantitat($this->quantitat);

		$copyObj->setData($this->data);

		$copyObj->setEstat($this->estat);

		$copyObj->setActiu($this->actiu);

		$copyObj->setSiteId($this->site_id);

		$copyObj->setTipus($this->tipus);

		$copyObj->setDescompte($this->descompte);

		$copyObj->setTpvOperacio($this->tpv_operacio);

		$copyObj->setTpvOrder($this->tpv_order);


		$copyObj->setNew(true);

		$copyObj->setIdentrada(NULL); // this is a auto-increment column, so set to default value

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
	 * @return     EntradesReserva Clone of current object.
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
	 * @return     EntradesReservaPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EntradesReservaPeer();
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
	  if (!$callable = sfMixer::getCallable('BaseEntradesReserva:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEntradesReserva::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEntradesReserva
