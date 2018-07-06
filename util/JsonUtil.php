<?php
class JsonUtil{
	public static function objectToArrayJson($obj){
		$arrayJson;
		$reflection = new ReflectionClass($obj);
		$atributosObjeto = $reflection -> getProperties(ReflectionProperty::IS_PRIVATE);
		foreach($atributosObjeto as $atributo){
			$nombreAtributo = $atributo -> getName();
			$funcionGet = 'get'. strtoupper(substr($nombreAtributo, 0, - (strlen($nombreAtributo) - 1))) . substr($nombreAtributo,1);
			if(method_exists($obj, $funcionGet)){
				$arrayJson[$nombreAtributo] = utf8_encode($obj->$funcionGet());
			}
		}
		return $arrayJson;
	}
		
	public static function objectToJson($obj){
		return json_encode(self::objectToArrayJson($obj));
	}
		
	public static function arrayObjectToJson($arrayObj){
		$arrayObjJson = array();
		foreach($arrayObj as $obj){
			array_push($arrayObjJson, self::objectToArrayJson($obj));
		}
		return json_encode($arrayObjJson);
	}
		
	public static function arrayObjectToArrayJson($arrayObj){
		$arrayObjJson = array();
		foreach($arrayObj as $obj){
			array_push($arrayObjJson, self::objectToArrayJson($obj));
		}
		return $arrayObjJson;
	}	
}
?>