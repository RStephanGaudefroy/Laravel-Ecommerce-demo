<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AdminRequest;
//use Illuminate\Support\Facades\Auth;
use DB;
use App\Product; 
use Session;
use Validator;

class ControlController extends Controller
{
    /**
     * function getGestionArticle
     * @return la vue control/gestionArticle
     */
    public function getGestionArticle() {
        $products = Product::all();
        return view('control.gestionArticle', ['products' => $products]);
    }


    /**
     * Suppression d'un article
     * @param: $id -> id de l'article
     */
    public function remove($id) {
        $product = Product::find($id);
        if ($product) {
            Session::flash('success', "L'article {$product->product_name} a bien été supprimé");
            $product->delete();
        }
        return redirect()->route('control.gestionArticle'); 
    }


    /**
     * Retourne la vue modifier un mouvement
     * @param {*} id : ID de l'article à afficher
     */
    public function update($id) {
        $product = Product::find($id);
        
        /**
         * Supprime la partie RANDOM et l'extension du nom de l'image
         * Pour permettre lors de l'enregistrement du UPDATE l'ajout à nouveau de ces valeurs
         * Sans risque de surcharger le nom de l'image 
         */ 
        $img = $product->image;
        if ( $img[4] == '-' and substr($img,-4,1) == '.') {
            $img = substr($product->image,5,-4);
        } 

        return view('control.update', compact('product','img') );  
    }


    /**
     * Fonction postUpdate
     * Redirection vers fonction Sauvegarde
     * @param {*} id : ID de l'article à enregistrer
     * @param {*} AdmninRequest -> données du formulaire
     * @return view control.gestionArticle avec message Success
     */
    public function postUpdate($id, AdminRequest $request) { 
        if ( $this -> sauvegarde($id, $request->all()) != true) {
            //dd($id);
            return Redirect::back()->withInput()->withErrors(['url' => ['Attention la destination de cette URL n\'est pas valide']]);
        } else {
            Session::flash('success', "L'article a été modifié avec succés");
            return redirect()->route('control.gestionArticle');    
        }
    }


    /**
     * @return vue Create
     */
    public function getCreate() {
        return view('control.create');  
    }


    /**
     * Fonction postCreate
     * Redirection vers fonction Sauvegarde
     * @param {*} AdmninRequest -> données du formulaire
     * @return view control.gestionArticle avec message Success
     */
    public function postCreate(AdminRequest $request) {
        $id = 'null';
        if ( $this -> sauvegarde($id, $request->all()) != true) {
            //dd($id);
            return Redirect::back()->withInput()->withErrors(['url' => ['Attention la destination de cette URL n\'est pas valide']]);
        } else {

            Session::flash('success', "L'article a été créé avec succés");
            return redirect()->route('control.gestionArticle');    
        }
    }


    /**
     * Fonction sauvegarde
     * @param {*} id : id produit pour UPDATE ou null si CREATE
     * @param {*} data : Données du formulaire UPDATE ou CREATE 
     */
    public function sauvegarde($id, $data) {
        if ($id === 'null') {
            $product = new Product();
        }   else {
            $product = Product::find($id);
        }

        // Traitement de l'url de l'image
        // Action : Ajoute une extension de type Random au debut du nom de l'image 
        $url = $data['url'];
        $title = $data['image'];
            
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        if ($extension) {
            $filename = str_random(4). '-' . $title . '.' . $extension;
        } else {
            $extension = substr($url, -3, 3);
            $filename = str_random(4). '-' . $title . '.' . $extension;
        }

        // Test de l'url 
        // Action : Download l'image dans le repertoire /image
        if ($this -> urlResponse($url) !=200) {
            $responseError = false; 
            return $responseError;
        } else {
            $file = file_get_contents($url);
            file_put_contents('image/'.$filename, $file);
        }
                            
        // Sauvegarde de l'enregistrement dans la table Product
        $product -> product_name = $data['name'];
        $product -> description = $data['description'];
        $product -> url = $url;
        $product -> image = $filename;
        $product -> price = $data['price'];

        $product -> save();
        $responseError = true;
        return $responseError;
    }

    /**
     * Fonction test de l'URL
     * @param url
     * @return reponse 200, 404, ....  
     */
    function urlResponse($url) {
        $headers = get_headers($url);
        return substr($headers[0],9, 3);
    }

}