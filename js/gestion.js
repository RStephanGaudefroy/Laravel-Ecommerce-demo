$(document).ready(function () {
    
    'use strict';
        
    /**
     * temps d'affichage des messages flash
     * @param delay : 5000 -> 5 secondes
     */
    $('div.alert-danger,div.alert-success,div.alert-info').delay(5000).slideUp('slow');


    /**
     * Transformation de la date -> Format Français 
     * @return Date -> Format littéraire
     * Affichage -> Formulaire contact
     */
    var today = new Date();
    var jourDate = new Array('Lundi', 'mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    var moisDate = new Array('janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    var dateDuJour = jourDate[today.getDay() - 1] + " " + today.getDate() + " " + moisDate[today.getMonth()] + " " + today.getFullYear();
    $("#dateJour").text(dateDuJour);

    
    /**
     * Gestion du media queries
     */
        var size = window.matchMedia("(max-width: 425px)");
        mediaQueries(size); 
        size.addListener(mediaQueries); 

        /**
         * Applique les changements css particulier
         * @param {*} size : taille ecran (max-width : 425px)
         */
        function mediaQueries(size) {
            if (size.matches) { 
                /** page cartview */
                $('#cartview-command').text("Commander");
                /** page contact */
                $('#messageContact').attr('rows', "20");
                /** page update */
                $('#descriptionUpdate').attr('rows', "7");
            } else {
                $('#cartview-command').text("Passer la commande");
                $('#messageContact').attr('rows', "10");
                $('#descriptionUpdate').attr('rows', "2");
            }
        };

        /**
         * Média Queries Tableau - Transformation du tableau en mode vertical
         * Vue -> Gestion article
         * Vue -> update
         */
        var tds = document.getElementsByTagName("td");
        for(var i=0; i<tds.length; i++){
            var td = tds[i];
            if(td.hasAttribute("headers")){
                var th = document.getElementById(td.getAttribute("headers"));
                if(th != null){
                    td.setAttribute("data-headers", th.textContent);
                }
            }        
        };

    /**
     * Validation du formulaire update ou create
     * @param : event sur SUBMIT
     * @return Err = TRUE = validation du formulaire, 
     * @return Err = FALSE = bloque la validation du formulaire
     */
    $("#formUpdate, #formCreate").submit(function(e){
        // ID du champ formulaire input ou textarea
        var id = ''; 
        // ValeurId = Contenu du champs input ou textarea
        var valeurId = ''; 
        // ResponseErr = booleens du retour de validation champs
        var responseErr;
        // Tableau contenant les erreurs
        var err = [];
        
        /**
         * boucle sur les champs INPUT et TEXTAREA du formulaire
         * pour tester la validité des champs
         */ 
        $('input, textarea').each(function() {
            if ($(this).attr('id') != undefined ) {
                id = "#" + $(this).attr('id');
                valeurId = $(this).val();
                
                if (!valeurId) {
                    responseErr = false;
                    var message = "Ce champs est requis";
                    colorErreur(id, message);
                } else {
                    responseErr = redirect(id, valeurId, responseErr);
                    //console.log('resultat validation = ', responseErr);
                }
                //console.log(err);
                err.push(responseErr);
            } 
        });
        
        // Recherche de la valeur FALSE dans ARRAY err
        if (err.indexOf(false) === -1 ) {
            return true;
        } else {
            return false;
        }
    });

    
    /**
     * Redirection vers les fonctions de vérification propres à chaque champs
     * @param {*} id : ID du champ formulaire input ou textarea
     * @param {*} valeurId : Valeur du champs input ou textarea
     * @return : resultat = TRUE or FALSE
     */
    function redirect(id, valeurId) {
        var resultat = false;
        var myRegex;
        var message = '';
        switch (id) {
            case '#priceUpdate' :
            case '#priceCreate' :
                resultat = verifPrice(id,valeurId);
                break;
                       
            case '#nameUpdate' :
            case '#nameCreate' :
                if (valeurId.length > 22 ) {
                    message = "La longueur de ce champs est fixé à 22 caractères maximum";
                    colorErreur(id, message);
                    resultat = false;
                } else {
                    myRegex =  /^[a-zA-Z0-9\ \,\.\-\_]{1,22}/;
                }
                break;
            
            case '#descriptionUpdate' :
            case '#descriptionCreate' :
                if (valeurId.length > 250 ) {
                    message = "La longueur maximale de ce champs est de 250 caractères maximum";
                    colorErreur(id, message);
                    resultat = false;
                } else {
                    myRegex =  /^[a-zA-Z0-9\ \,\.\-\_]+/;
                }
                break;

            case '#urlUpdate' :
            case '#urlCreate' :
                //myRegex = /^http:\/\/.*\/(.*?).(jpe?g|png)$/;
                myRegex = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+([\.\/]{1}(jpg|png))$/;
                break;

            case '#imageUpdate' :
            case '#imageCreate' :
                myRegex =  /^([a-zA-Z0-9-_ ]{2,30})+/;
                break;
        }
        
        if (myRegex) {
            resultat = verifRegex(id, valeurId, myRegex);
        }
        return resultat;
    };


    /**
     * Fonction verifRegex
     * Verification des champs à base de REGEX
     * @param {*} id 
     * @param {*} valeurId 
     * @param {*} myRegex 
     * @return result : TRUE or FALSE
     */
    function verifRegex(id, valeurId, myRegex) {
        console.log('ici verif regex', valeurId,  id);
        var result;
        if (!myRegex.test(valeurId)) {
            var message = "Ce champs n'est pas valide";
            colorErreur(id, message);
            result = false;
        } else {
            colorSuccess(id);
            result = true;
         }
        return result;
    };
    

    /**
     * Fonction vérification du champs PRICE
     * @param {*} id : ID du champ formulaire input ou textarea
     * @param {*} price : Valeur du champs ID -> format PARSEFLOAT
     * @return resultPrice : TRUE or FALSE
     */
    function verifPrice(id, valeurId) {
        //console.log('fonction verif price', id, valeurId);
        var resultPrice;
        var price = parseFloat(valeurId);
        if (price == 0 || price < 0 || isNaN(price) ) {
            var message = "Ce champs n'est pas valide";
            colorErreur(id, message);
            resultPrice = false ;
            //console.log('ici une erreur prix', resultPrice);
        } else {
            colorSuccess(id);
            resultPrice = true;
            //console.log('ici ok', resultPrice);
        }
        
        return resultPrice;
    };


    /**
     * Fonction modifie bordure CSS sur champs avec erreur
     * @param {*} id : ID du champ formulaire input ou textarea 
     * @param {*} message : Message d'erreur selon l'erreur rencontré 
     */
    function colorErreur (id, message) {
        $(id).next().removeAttr("hidden");
        $(id).next().text(message); 
        $(id).css("border", "3px solid red");
    };
    

    /**
     * Fonction modifie bordure CSS sur champs avec erreur
     * @param {*} id : ID du champ formulaire input ou textarea  
     */
    function colorSuccess (id) {
        $(id).next().prop("hidden", true); 
        $(id).css("border", "3px solid green"); 
    };

    
    /**
     * Gestion du systeme de paiement Stripe 
     */
    //document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';  
    Stripe.setPublishableKey('pk_test_********************');
        var $form = $('#paycard-form');

        $form.submit(function(event) {
            $('#charge-error').addClass('hidden');
            $form.find('.bouton').prop('disabled', true);
            Stripe.card.createToken({
                name: $('#card-name').val(),
                number: $('#card-number').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);
            return false;
        });

        function stripeResponseHandler(status, response) {
            if (response.error){
                $('#charge-error').removeClass('hidden');
                $('#charge-error').text(response.error.message);
                $form.find('.bouton').prop('disabled', false);
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                $form.get(0).submit();
            }
        }
});