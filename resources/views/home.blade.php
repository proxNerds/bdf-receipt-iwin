@extends('app')

@section('content')
    <div class="container">
        {{-- FORM SECTION --}}
        <div id="logged" class="hidden">

            <div id="contestForm-container" class="row mb-5">
                <div class="col-12">
                    <form id="contestForm needs-validation" name="contestForm" role="form" action="" method="POST"
                        enctype="multipart/form-data" novalidate>
                        <input type="hidden" id="is_registered" name="is_registered" value="0">
                        <input type="hidden" id="crm_id" name="crm_id" value="">
                        {{-- <input type="hidden" id="email" name="email" value=""> --}}
                        <input type="hidden" id="birthdate" name="birthdate" value="">
                        <input type="hidden" id="privacy_tc" name="privacy_tc">
                        <input type="hidden" id="product_total" name="product_total">
                        <input type="hidden" id="privacy_age" name="privacy_age">
                        <input type="hidden" id="newsletter" name="newsletter">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="mainHeader row">
                            <div class=" col-12 mt-5 text-center">
                                {{-- <h3 style="font-weight: bold; line-height: 39px">I TUOI DATI</h3> --}}
                                <h3 class="nx-font-heading-3 font-weight-bold nx-txt-uppercase">I TUOI DATI</h3>
                                <p id="loginMessage" class="hidden">Se sei già registrato effettua il <a href="#" id="loginUrl">login</a> prima di partecipare.</p>
                            </div>
                        </div>
                        <div class="row" style="display: flex; justify-content: center;">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <div class="form-group did-floating-label-content">
                                            <input type="email" class="form-control did-floating-input input-lg "
                                                id="email" name="email" placeholder="" autocomplete="off" required />
                                            <label class="did-floating-label email" for="email">E-mail*</label>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="email_err"></div>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="crm_id_err"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="text" class="form-control did-floating-input input-lg "
                                                id="firstname" name="firstname" placeholder="" autocomplete="off"
                                                required />
                                            <label class="did-floating-label firstname" for="firstname">Nome*</label>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="firstname_err"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="text" class="form-control did-floating-input input-lg "
                                                id="lastname" name="lastname" placeholder="" autocomplete="off" required />
                                            <label class="did-floating-label lastname" for="lastname">Cognome*</label>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="lastname_err"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="text" class="form-control did-floating-input input-lg "
                                                id="phone" name="phone" placeholder="" autocomplete="off" required />
                                            <label class="did-floating-label phone" for="phone">Telefono*</label>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="phone_err"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="date" class="form-control did-floating-input input-lg "
                                                id="dob" name="dob" placeholder="" autocomplete="off"
                                                required />
                                            <label class="did-floating-label dob" for="dob">Data di nascita*</label>
                                            <div class="invalid-tooltip invalidFormInput pb-0" id="dob_err"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mainHeader row mb-3">
                            <div class=" col-12 mt-5 text-center">
                                <h3 class="nx-font-heading-3 font-weight-bold nx-txt-uppercase">INSERISCI QUI I
                                    DATI<br>
                                    <span>DEL TUO SCONTRINO</span>
                                </h3>
                                {{-- <h3 style="font-weight: bold; line-height: 39px">INSERISCI QUI I DATI</h3> --}}
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12 col-sm-4">
                                <div class="row">
                                    {{--   <div class="col-12 text-left">
                                     <button type="button" class="helperPopover btn question ml-2 mb-1" data-html="true"
                                            data-toggle="popover" title=""
                                            data-content='Clicca nel riquadro GG/MM/AA e seleziona dal calendario la data in cui il tuo scontrino è stato emesso.'
                                            data-trigger="hover focus" data-placement="bottom"
                                            data-original-title="Inserire la data di emissione dello scontrino">?</button>
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="form-group did-floating-label-content">
                                            <input type="date" class="form-control did-floating-input input-lg "
                                                id="receipt_date" name="receipt_date" placeholder="" autocomplete="off"
                                                required />
                                            <label class="did-floating-label receipt_date" for="receipt_date">Data
                                                emissione*</label>

                                            <div class="invalid-tooltip invalidFormInput pb-0" id="receipt_date_err">
                                            </div>
                                            <div class="invalid-tooltip invalidFormInput py-0"
                                                id="receipt_date_range_err">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-8">
                                <div class="row">
                                    {{--   <div class="col-12 text-left">

                                     <button type="button" class="helperPopover btn question ml-2 mb-1"
                                            data-toggle="popover" title=""
                                            data-content="Per indicare, per esempio, le ore 7 e 23 minuti scrivi 0703."
                                            data-trigger="hover focus" data-placement="bottom"
                                            data-original-title="Inserire l'orario di emissione dello scontrino">?</button>
                                    </div> --}}
                                    <div class="col-6">
                                        <div class="form-group did-floating-label-content">
                                            {{-- <div class="divider">.</div> --}}
                                            <input type="text" class="form-control did-floating-input input-lg"
                                                id="receipt_hour" name="receipt_hour" maxlength="2" placeholder=""
                                                onkeypress="return App.Forms.handleMaxNumber(event, '#receipt_hour')"required />
                                            <label class="did-floating-label receipt_hour" for="receipt_hour">Orario
                                                emissione*</label>
                                            {{-- TOOLTIP INFO MESSAGE --}}
                                            <div class="invalid-tooltip invalidFormInput" id="receipt_hour_err"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="text" class="form-control did-floating-input input-lg"
                                                id="receipt_minute" name="receipt_minute" maxlength="2" placeholder=""
                                                onkeypress="return App.Forms.handleMaxNumberMin(event, '#receipt_minute')"
                                                required />
                                            <label class="did-floating-label receipt_minute" for="receipt_minute">Minuti
                                                emissione*</label>

                                            <div class="invalid-tooltip invalidFormInput" id="receipt_minute_err"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 col-sm-4">
                                <div class="row">
                                    {{--   <div class="col-12 text-left">
                                     <a tabindex="0" role="button" id="popoverWithImg"
                                        class="helperPopover btn question ml-2 mb-1" data-toggle="popover"
                                        data-html="true" title=""
                                        data-content="<img class='scontrinoImg' src='{{ asset('img/numeroProgressivo.png') }}'/>"
                                        data-placement="bottom"
                                        data-original-title="Inserire il numero indicato come da immagine">?</a>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="form-group did-floating-label-content">
                                            <div>
                                                <input type="text" name="receipt_number" maxlength="15"
                                                    class="form-control did-floating-input input-lg" id="receipt_number"
                                                    placeholder="" required />
                                                <label class="did-floating-label receipt_number"
                                                    for="receipt_number">Numero
                                                    scontrino*</label>

                                                <div class="invalid-tooltip invalidFormInput" id="receipt_number_err">
                                                </div>
                                            </div>

                                            <p class="form-text note niveaBlue">Da compilare senza gli zeri che precedono
                                                il
                                                numero stesso.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-8">
                                <div class="row">
                                    {{-- <div class="col-12 text-left">
                                    <button type="button" class="helperPopover btn question ml-2 mb-1"
                                            data-toggle="popover" title=""
                                            data-content="Per indicare, per esempio, l’importo pari a 19,15€ scrivi 1915."
                                            data-trigger="hover focus" data-placement="bottom"
                                            data-original-title="Inserire l'importo dello scontrino">?</button>
                                    </div> --}}
                                    <div class="col-6">
                                        <div class="form-group did-floating-label-content">
                                            {{-- <div class="divider">,</div> --}}
                                            <input type="text" name="totalEuro" maxlength="3"
                                                class="form-control did-floating-input input-lg" id="inputEuro"
                                                placeholder="" onkeypress="return App.Forms.handleKeyStrokes(event)"
                                                required />
                                            <label class="did-floating-label inputEuro" for="inputEuro">Importo
                                                euro*</label>

                                        </div>
                                        <div class="divider">,</div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group did-floating-label-content">
                                            <input type="text" name="totalCentesimi"
                                                class="form-control did-floating-input input-lg" id="inputCentesimi"
                                                placeholder="" maxlength="2"
                                                onkeypress="return App.Forms.handleKeyStrokes(event)" required />
                                            <label class="did-floating-label inputCentesimi" for="inputCentesimi">Importo
                                                decimali*</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="invalid-tooltip invalidFormInput" style="margin-top: -14px;"
                                            data-toggle="tooltip" id="receipt_total_err"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="invalid-tooltip invalidFormInput" id="receipt_duplicate_err"></div>
                        </div>
                        {{--     <div class="row mt-5 mb-5 text-left">
                            <div class="col-12 col-md-12 mb-5">
                                <label for="">Carica una foto del FRONTE dello scontrino*</label>
                                <p class="note grey">Accertati che l’immagine sia leggibile, che non superi la
                                    dimensione di
                                    4 MB e che sia in formato jpeg, png, gif o webp.</p>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="receipt_img1_url"
                                        id="receipt_img1_url" onchange="App.Forms.preview_img(event, 1)">
                                    <label class="custom-file-label" for="file-fronte" data-browse="sfoglia">Carica
                                        file</label>
                                    <div class="invalid-tooltip invalidFormInput" id="receipt_img1_url_err"></div>
                                </div>

                                <img id="output_image1" class="m-3" width="150" /><span id="imageModalBtn1"
                                    class="imageModalBtn hidden m-3" data-num="1">Ingrandisci</span>
                            </div>
                            <div class="col-12 col-md-12">
                                <label for="">Carica una foto del RETRO dello scontrino</label>
                                <p class="note grey">Accertati che l’immagine sia leggibile, che non superi la
                                    dimensione di
                                    4 MB e che sia in formato jpeg, png, gif o webp.</p>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="receipt_img2_url"
                                        id="receipt_img2_url" onchange="App.Forms.preview_img(event, 2)">
                                    <label class="custom-file-label" for="file-retro" data-browse="sfoglia">Carica
                                        file</label>
                                </div>
                                <div class="invalid-tooltip invalidFormInput" id="receipt_img2_url_err"></div>

                                <img id="output_image2" class="m-3" width="150" /><span id="imageModalBtn2"
                                    class="imageModalBtn hidden m-3" data-num="2">Ingrandisci</span>
                            </div>

                        </div> --}}

                        <div class="row pl-3 pr-3 mt-4 mb-2">
                            <div class="col-12 p-0">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <div class="checkbox-wrapper">
                                            <label class="form-check container" id="privacylabel">
                                                <input class="checkboxPrivacy" type="checkbox" name="privacy_tc_check"
                                                    id="privacy_tc_check" value="" required>
                                                <span class="checkmark squared"></span>&nbsp;&nbsp;* Dichiaro di aver letto
                                                e compreso il regolamento e di accettare le sue
                                                norme e le condizioni generali di partecipazione.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div id="privacyAgeCheck" class="col-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <div class="checkbox-wrapper">
                                            <label class="form-check container" id="privacyAgelabel">
                                                <input class="checkboxAge" type="checkbox" name="privacy_age_check"
                                                    id="privacy_age_check" value="" required>
                                                <span
                                                    class="labelForm_scontrino_submit checkmark squared"></span>&nbsp;&nbsp;*
                                                * Dichiaro di avere compiuto la maggiore età
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <div class="internal-error-msg invalidFormInput" id="birthdate_err"
                                    style="color: red; font-weight: bold;"></div>
                                <div class="internal-error-msg" id="internalErrorMsg"
                                    style="color: red; font-weight: bold;"></div>
                                <button id="submitBtn" class="nx-btn btnCenter   nx-font-button-text-large submitBtn">
                                    <span class="text">INVIA LA RICHIESTA</span>
                                    {{-- <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">...</span>
                                </div> --}}
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center mt-4">
                                <p class="note" style="color: #0032a0;">*Campi obbligatori</p>
                            </div>
                        </div>
                </div>

                </form>
            </div>



            <div id="winner" class="row mb-5 d-none outer-border text-center align-items-center flex-column p-2">
                <div class="col-12">
                    <h2 class="mt-5 mb-0 text-center nx-u-text__headline nx-u-mb-base-2 nx-font-heading-2 nx-font--extrabold nx-txt-uppercase" style="color: #0032a0">CONGRATULAZIONI!<br>
                        Hai vinto un buono Airbnb da 100€!</h2><br>
                    <p>Controlla la tua casella di posta. Ti abbiamo inviato una e-mail con le istruzioni per la convalida
                        della tua vincita.</p><br>
                    <br>
                    <p>Codice di vincita: <span class="wincode" style=" color: #0032a0; margin: 15px 0px"></span></p>
                    <br><br>
                </div>
                <div class="col-12">
                    <img src="{{ asset('img/TYP_winner_img.png') }}" alt="" style="width:40%">
                </div>
            </div>

            <div id="loser" class="row mb-5 d-none outer-border text-center align-items-center flex-column p-2">
                <div class="col-12">
                    <h2 class="mt-5 mb-0 text-center nx-u-text__headline nx-u-mb-base-2 nx-font-heading-2 nx-font--extrabold nx-txt-uppercase">GRAZIE PER AVER PARTECIPATO!</h2>
                    <p>Purtroppo, non ti sei aggiudicato nessun premio.<br>
                        Ma non preoccuparti: puoi ritentare la fortuna!<br>
                        Inoltre, ti abbiamo inserito in lista per l’eventuale estrazione a recupero dei premi non assegnati,
                        che avverrà entro il 15/09/25.
                    </p>
                </div><br><br>
                <div class="col-12">
                    <img src="{{ asset('img/TYP_loser_img.png') }}" alt="" style="width:50%">
                </div>
            </div>
            <div id="subscriptionBlock" class="col-12 d-none text-center"> <!-- Subscription block -->
                <h3
                    class="text-center nx-u-text__headline nx-u-mb-base-2 nx-font-heading-3 nx-font--extrabold nx-txt-uppercase">
                    <center>Iscriviti a my<span class="nx-no-hyphens">NIVEA</span></center>
                </h3>
                <div class="nx-expander__content nx-font-body-1">
                    <div>
                        <p style="text-align: center;">Iscriviti alla Community My<span class="nx-no-hyphens">NIVEA</span>
                            per ricevere contenuti esclusivi e personalizzati in
                            base ai tuoi interessi e attività (es. Newsletter periodica, campioni, sconti, buoni,
                            informazioni su nuovi prodotti e concorsi)</p>
                    </div>

                    <div class="nx-cp">
                        <div class="nx-content-zone__cta nx-content-zone__cta--center nx-cp" data-tdata=""
                            data-tracking-initialized="true">
                            <a id="registrationCTA" href="#"
                                class="nx-btn nx-btn--secondary nx-btn__content-zone  "
                                style="--CTAButtonBackgroundColor:var(--BaseInteractionColor);--CTAButtonBorderColor:var(--BaseInteractionColor);--CTAButtonHoverBackgroundColor:#F3F7FE;--CTAButtonHoverBorderColor:var(--BaseInteractionColor);--CTAButtonHoverTextColor:var(--BaseInteractionColor);--CTAButtonTextColor:#ffffff">Clicca
                                qui</a>
                        </div>
                    </div>
                </div>
            </div> <!-- End Subscription block -->





        </div>
    </div>


    {{-- NOT CONFIMED --}}
    <div class="container">
        <div id="notConfirmed" class="hidden ">
            <div class="row">
                <div class="col text-center">
                    Per partecipare devi completare la registrazione.
                </div>
            </div>
        </div>
    </div>

    {{-- NOT LOGGED IN --}}
    <div class="container">
        <div id="notlogged" class="hidden ">
            <div class="row mt-5 mb-5">
                <div class="col text-center" style="display: flex; justify-content: center; align-items: center;">
                    {{-- <h3 class="mb-5">PARTECIPA ALLA <br>COMMUNITY MYNIVEA</h3> --}}
                    {{-- <p>accedi alla community<br> myNivea o registrati subito!</p> --}}

                    <a href="" id="loginBtn" class=" niveaBTN position-relative mt-3"
                        style="text-decoration: none; display: flex; justify-content: center; align-items: center;">
                        <span class="text">PARTECIPA ORA</span>
                    </a>
                    {{-- <div><a href="" id="registerBtn"><span class="btn-submit btn btn-primary text-center mt-4">REGISTRATI
                                SUBITO</span></a></div> --}}


                </div>
            </div>
        </div>
    </div>
@endsection
