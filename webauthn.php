<?php
function b64u_encode(string $v): string { return rtrim(strtr(base64_encode($v),'+/','-_'),'='); }
function b64u_decode(string $v): string|false { return base64_decode(strtr($v.'===','-_','+/'),true); }
function cbor_read(string $data,int &$i): mixed {
  if($i>=strlen($data)) throw new RuntimeException('CBOR incompleto');
  $first=ord($data[$i++]);$major=$first>>5;$add=$first&31;
  if($add<24)$n=$add;elseif($add===24){$n=ord($data[$i++]);}elseif($add===25){$n=unpack('n',substr($data,$i,2))[1];$i+=2;}elseif($add===26){$n=unpack('N',substr($data,$i,4))[1];$i+=4;}else{throw new RuntimeException('CBOR não suportado');}
  if($major===0)return $n;if($major===1)return -1-$n;
  if($major===2){$v=substr($data,$i,$n);$i+=$n;return $v;}
  if($major===3){$v=substr($data,$i,$n);$i+=$n;return $v;}
  if($major===4){$out=[];for($x=0;$x<$n;$x++)$out[]=cbor_read($data,$i);return $out;}
  if($major===5){$out=[];for($x=0;$x<$n;$x++){$k=cbor_read($data,$i);$out[is_int($k)?(string)$k:(string)$k]=cbor_read($data,$i);}return $out;}
  if($major===7)return $add;
  throw new RuntimeException('CBOR inválido');
}
function webauthn_rp_id(): string { global $cfg; $url=(string)($cfg['base_url']??'');$host=(string)(parse_url($url,PHP_URL_HOST)?:'localhost');return strtolower(preg_replace('/:\d+$/','',$host)); }
function webauthn_origin(): string { global $cfg; return rtrim((string)($cfg['base_url']??''),'/'); }
function webauthn_json(): array { $v=json_decode(file_get_contents('php://input'),true);if(!is_array($v))throw new RuntimeException('JSON inválido');return $v; }
function webauthn_public_pem(string $x,string $y): string { $der=hex2bin('3059301306072a8648ce3d020106082a8648ce3d03010703420004').$x.$y;return "-----BEGIN PUBLIC KEY-----\n".chunk_split(base64_encode($der),64,"\n")."-----END PUBLIC KEY-----\n"; }
function webauthn_client_data(array $client,string $type,string $challenge): void { if(($client['type']??'')!==$type||($client['challenge']??'')!==$challenge||($client['origin']??'')!==webauthn_origin())throw new RuntimeException('Origem ou desafio inválido.'); }
function webauthn_auth_data(string $authData): array { if(strlen($authData)<37)throw new RuntimeException('AuthenticatorData inválido');$flags=ord($authData[32]);$count=unpack('N',substr($authData,33,4))[1];return ['flags'=>$flags,'count'=>$count]; }
function json_out(array $data,int $status=200): void { http_response_code($status);header('Content-Type: application/json; charset=utf-8');echo json_encode($data,JSON_UNESCAPED_UNICODE);exit; }
