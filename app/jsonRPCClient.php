<?php

namespace App;

class jsonRPCClient
{
	protected $host, $port, $version;
	protected $id = 0;
	
	function __construct($host, $port, $version="2.0")
	{
		$this->host = $host;
		$this->port = $port;
		$this->version = $version;
	}
	
	function request($method, $params=array())
	{
		$data = array();
		$data['jsonrpc'] = $this->version;
		$data['id'] = $this->id++;
		$data['method'] = $method;
		$data['params'] = $params;
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host);
		curl_setopt($ch, CURLOPT_PORT, $this->port);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		
		$ret = curl_exec($ch);
		
		if($ret !== FALSE)
		{
			$formatted = $this->format_response($ret);
			
			if(isset($formatted->error))
			{
                print_R($formatted->error);
				// throw new RPCException($formatted->error->message, $formatted->error->code);
			}
			else
			{
				return $formatted;
			}
		}
		else
		{
			throw new RPCException("Server did not respond");
		}
	}
	
	function format_response($response)
	{
		return @json_decode($response);
	}
	
	function dec2hex($dec)
	{
		$dec = number_format($dec, 0, '.', '');
		$hex = '';
		do {    
			$last = bcmod($dec, 16);
			$hex = dechex($last).$hex;
			$dec = bcdiv(bcsub($dec, $last), 16);
		} while($dec>0);
		return $hex;
	} 
}

class RPCException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString() 
    {
        return __CLASS__ . ": ".(($this->code > 0)?"[{$this->code}]:":"")." {$this->message}\n";
    }
}