<?php

require_once '../lib/vendor/googleapis/Google_Client.php';
require_once '../lib/vendor/googleapis/contrib/Google_CalendarService.php';

class Connectivitat 
{

    public static $client;
    public static $cal; 
    public static $AccessToken;


    public function __construct( $idS ){
        
        $apiConfig['use_objects'] = true;
        $this->client = new Google_Client();
        //$client->setApplicationName("Google Calendar PHP Starter Application");
        
        // Visit https://code.google.com/apis/console?api=calendar to generate your
        // client id, client secret, and to register your redirect uri.
        
        $this->client->setClientId( OptionsPeer::getString( 'GOOGLE_CLIENT_ID' , $idS ) );
        $this->client->setClientSecret( OptionsPeer::getString( 'GOOGLE_CLIENT_PASSWORD' , $idS ) );
        $this->client->setRedirectUri( OptionsPeer::getString( 'GOOGLE_REDIRECT_URI' , $idS ) );
        
        $this->cal = new Google_CalendarService($this->client);                                                
        
    }
    
    //Codie que retorna google d'autentificació
    public function setCodeAuth($code){
        $this->client->authenticate( $code );
    }

    public function IsConnected( $idS ){
        if ( $this->client instanceof Google_Client && $this->client->getAccessToken() ) return true; 
        else return false;    
    }
    
            
    //Token que usem per treballar amb google
    public function setAuthCode( $token ){             
        if(!is_null($token)) $this->client->setAccessToken($token);                                       
    }
    
    public function getAuthCode(){
        return $this->client->getAccessToken();
    }    

    public function ConnectaGoogle( $idS , $force_login = 0 ){
                
        //Si forcem que es faci un login, entrem directament l'authUrl
        if($force_login) return $this->client->createAuthUrl();
        else {
        
            //Si hem guardat a la variable de Sessió el token, el recarreguem
            if (isset($_SESSION['token'])) {
              $this->client->setAccessToken($_SESSION['token']);
            }
    
            //Si ja tenim el token, fem l'acció
            if ($this->client->getAccessToken()) $_SESSION['token'] = $this->client->getAccessToken();           
            else return $this->client->createAuthUrl();
        }
                
    }        
    
    
    public function AddActivitat( $id , $timestamp_inici, $timestamp_fi , $organitzador , $email , $titol , $link , $location , $summary , $description , $calendarid , $color_id , $idS ){
        
        date_default_timezone_set('Europe/Madrid');
        //echo date(DateTime::RFC3339,mktime(17,30,00,1,14,2013));
                
        $E = new Google_Event();
        
        $O = new Google_EventOrganizer();
        $O->setDisplayName( $titol );
        $O->setEmail( $email );
        $E->setOrganizer($O);
        
        $E->setSummary( $titol );
        $E->setHtmlLink( $link );
        $E->setLocation( $location );
        $E->setDescription( $description );
        
        $start = new Google_EventDateTime();
        $start->setDateTime( date( DateTime::RFC3339, $timestamp_inici ) );
        $E->setStart($start);
        
        $end = new Google_EventDateTime();
        $end->setDateTime( date( DateTime::RFC3339, $timestamp_fi ) );
        $E->setEnd($end);
        $E->setColorId( $color_id );
        
        $this->cal->events->insert( OptionsPeer::getString( 'GOOGLE_CALENDAR_ID' , $idS ) , $E );                
                    
    }
      

    
}