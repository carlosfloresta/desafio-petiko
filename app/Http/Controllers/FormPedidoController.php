<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class FormPedidoController extends Controller
{
    public function index()
    {
        return view('form-pedido');
    }

    public function buscaCep(Request $req)
    {
        //Validando o CEP se ele existe é numero e se tem 8 digitos
        $req->validate([
            'cep' => 'required|numeric|digits_between:8,8',
        ]);
        $cep = $req->input('cep');
        return response()->json($this->apiCEP($cep));
    }

    public function create(Request $req)
    {
        //Validando os campos que não passam pela api
        $req->validate([
            'cep' => 'required|numeric|digits_between:8,8',
            'nome' => 'required|min:5|max:200',
            'numero' => 'required|max:10|min:1',
            'complemento' => 'max:100',
        ]);
        $cep = $req->input('cep');
        $api = $this->apiCEP($cep);
        //validando se usuario não alterou cep por um invalido
        if (isset($api->erro)) {
            return response()->json($this->apiCEP($cep));
        }
        //validando se o endereco esta igual a api
        $req->validate([
            'logradouro' => 'required|in:' . $api->logradouro,
            'bairro' => 'required|in:' . $api->bairro,
            'cidade' => 'required|in:' . $api->localidade,
            'estado' => 'required|in:' . $api->uf,
        ]);
        //salva o pedido no BD
        $criapedido = Pedido::create([
            'nome' => $req->input('nome'),
            'cep' => $req->input('cep'),
            'logradouro' => $req->input('logradouro') . ', ' . $req->input('numero'),
            'complemento' => $req->input('complemento'),
            'bairro' => $req->input('bairro'),
            'cidade' => $req->input('cidade'),
            'estado' => $req->input('estado'),
        ]);

        if ($criapedido) {
            return response()->json([
                'message' => 'Pedido recebido! Obrigado pela confiança, seu brinde chegará em breve :)',
            ]);
        } else {
            return response()->json([
                'erro' => 'Falaha ao salvar seu pedido, por favor tente novamente!',
            ]);
        }
    }

    public function apiCEP($cep)
    {
        //API Via CEP
        $url = "https://viacep.com.br/ws/$cep/json/";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
        $result = json_decode(curl_exec($ch));
        curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //$status_code = 0;

        //se o status do codigo não foi 200(sucesso) ou ele retonar algum erro ele executa a segunda opção de API da POSTMON
        if ($status_code != 200 || isset($result->erro)) {

            $url = "https://api.postmon.com.br/v1/cep/$cep";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
            $result = json_decode(curl_exec($ch));
            curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            //Se retornar null o cep não foi encontrado
            if ($result == null) {
                $result = [
                    'erro' => 'CEP não encontrado, por favor verifique e tente novamente!',
                ];
                //Se não retonar o codigo 200, ouve algum erro na busca do cep ou esgotou o tempo determnado de 5000 ms
            } elseif ($status_code != 200) {
                $result = [
                    'erro' => 'Erro interno no servidor, por favor tente novamente mais tarde!',
                ];
                //Se não aocntecer nada disso ele faz a mudança de key de cidade para localidade e de estado para UF para ficar igual a primeira API e não precisar alterar no front.
            } else {
                $result->localidade = $result->cidade;
                unset($result->cidade);
                $result->uf = $result->estado;
                unset($result->estado);
                //Aqui se não existir complemento ele define como vazio, isso para não aparecer como undefined já que está API não traz o complemento quando ele esta vazio.
                if (!isset($result->complemento)) {
                    $result->complemento = '';
                }
            }
        }
        //por fim retorna o resultado.
        return $result;
    }
}
