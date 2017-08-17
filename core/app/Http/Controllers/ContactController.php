<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Validator;
use Illuminate\Support\Facades\Session;
use App\Product;

class ContactController extends Controller
{
    /**
     * function getContact
     * Return view contact/pageContact
     */
    public function pageContact() {
        
        return view('contact/pageContact');    
    }

    /**
     * Function postContact
     * @param Request -> [mailContact, messageContact]
     * Use Validator  -> if errors return view contact/pageContact with errors
     * Use Mail::Send -> send mail and return view index with success message 
     */
    public function postContact(Request $request) {
        
        if ($request -> isMethod('post' )) {

            $validator = Validator::make($request -> all(), [
                //'nomContact' => 'required',
                'mailContact' => 'required|email',
                'messageContact' => 'required|min:1',
            ]);

            // si la validation échoue
            if ($validator->fails()) {
                Session::flash('error', "Attention le formulaire contient des erreurs");
                return redirect('contact/pageContact')->withErrors($validator)->withInput();
                
            } 
            // sinon on envoi le mail
            else {
                
                Mail::send('contact.mailContact', array(
                    
                    'name' => $request->get('nomContact'),
                    'email' => $request->get('mailContact'),
                    'content' => $request->get('messageContact')

                ), function ($message) {
                    
                    $message->to('stephan.gaudefroy@gmail.com', 'Site admin')                 		
                    ->subject('Formulaire Contact'); 
                });

                Session::flash('success', "Votre message à bien été envoyé à l'administrateur du site");
                return redirect()->route('product.index');
            }

        }
    }

} // Fin de la classe