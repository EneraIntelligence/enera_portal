@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/welcome.css')) !!}

    <!-- branch colors -->
    <style>
        body {
            background-color: #e8eaf6;
        }
        footer.page-footer {
            background-color: #3f51b5;
        }
    </style>
@stop

@section('title', 'Bienvenido')

@section('header')

    <script>
        <?php
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        var actualLink = "{!! $actual_link !!}";
        var currentUrl = window.location.href;
        if( !currentUrl.includes("enera-intelligence.mx") )
        {
            window.location.href = actualLink;
        }
    </script>

@stop

@section('content')

    <!-- Main card -->
    <div class="welcome card small z-depth-2">
        <img class="responsive-img" style="margin-bottom: -6px;"
             src="http://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/{!! $image !!}">
    </div>
    <!-- Main card -->

    <!-- checkbox terminos y condiciones -->
    <div class="terms card small" id="terms-card">
        <p class="center-align">

            <input type="checkbox" id="terms-checkbox"/>
            <label for="terms-checkbox">Acepto los <a class="modal-trigger" href="#terms-modal">Términos y
                    condiciones</a></label>
        </p>
    </div>
    <!-- checkbox terminos y condiciones -->

    <!-- login buttons -->
    <div class="login card small center-align" id="login-card">
        <p>
{{--            {{ $message['text'] }}--}}
            Para navegar
        </p>
        <a class="waves-effect waves-light btn fb-btn indigo darken-1 login-btn"
           onclick="showLoader('fb-loader')" href="#!" data-progress="fb-loader"
           id="fb-btn">
            <img class="btn-logo" src="{!! asset('img/FB.png') !!}" alt="">
            Conectar con Facebook

            <div class="progress" id="fb-loader">
                <div class="indeterminate"></div>
            </div>
        </a>


    </div>
    <!-- login buttons -->


    <!-- Modal términos y condiciones -->
    <div class="modal modal-fixed-footer" id="terms-modal">
        <div class="modal-content">
            <h4>Términos y condiciones</h4>


            <!-- comienza términos y condiciones-->

            <h5>Aviso de Privacidad</h5>

            <p class="justify">El presente documento constituye el “Aviso de Privacidad” de COVE CORPORATIVO TECNOLÓGICO
                S.A. DE
                C.V., (en lo sucesivo “COVE CORPORATIVO”), en donde se establece la manera en que será tratada
                su información por parte de COVE CORPORATIVO TECNOLÓGICO, así como la finalidad para la que fue
                recabada, lo anterior de conformidad con los Artículos 15 y 16 de Ley Federal de Protección de
                Datos Personales en Posesión de Particulares, con domicilio para recibir notificaciones en Av.
                Vallarta 6503 local E-16 Plaza Concentro, Ciudad Granja Zapopan Jalisco, México, C.P. 45010.</p>

            <strong>Datos personales que recaba COVE CORPORATIVO.</strong>

            <p class="justify">Son los datos personales, de identificación y/o financieros y/o profesionales
                proporcionados por
                usted de manera directa o por cualquier medio, foro público de conexión en línea relacionados
                con: (I.-) nombre, domicilio, fecha de nacimiento, correo electrónico, CURP, RFC, teléfono fijo,
                teléfono móvil, los servicios que presta COVE CORPORATIVO incluyendo sin limitación alguna la
                prestación de servicio local de servicio de internet, usuario visitante, servicios adicionales
                de comunicación, análisis de mercado, hábitos de consumo, preferencias de consumo, alianzas
                comerciales, publicidad y mercadotécnica, difusión en el lanzamiento de productos y/o servicios,
                ofertas comerciales, promociones temporales, (II.-) información técnica relativa al acceso y/o
                uso de los Servicios de internet, entre la que se encuentra comprendida el IMEI o número de
                serie del equipo terminal, así como la fecha, hora y duración de acceso a servicios de
                transmisión de datos, volúmenes de datos trasmitidos y recibidos y (III.-) cualesquiera otros
                datos que se recaben de tiempo en tiempo con motivo de la prestación de los Servicios de
                internet.</p>

            <strong>FINALIDADES PRIMARIAS</strong>

            <p class="justify">COVE CORPORATIVO tratará sus datos personales para llevar a cabo alguna o todas las
                actividades
                necesarias para el cumplimiento comercial de la prestación de los Servicios, tales como alta,
                baja, cambio de Servicios y/o usuario, registro, gestión de servicios y/o aplicaciones que se
                ofrecen en el sitio web, propio y a través de alianzas comerciales vigentes.</p>

            <p class="justify">Los datos personales que recaba COVE CORPORATIVO son utilizados principalmente para
                brindarle un
                apoyo en cuanto a los productos y servicios de su interés tales como:</p>

            <p class="justify">
                a.- Creación y administración de su cuenta.
                b.- Lanzamiento y desarrollo de nuevos productos y/o servicios.
                c.- Interrelación de bases de datos para conocer el perfil y las necesidades del cliente y/o
                usuarios. d.- Envío de publicidad y promociones sobre productos o servicios de su interés.
                e.- Análisis a fin de determinar la eficacia de nuestra publicidad y promociones.
                f.- Estudios de mercado.
                g.- Conocer sus gustos y preferencias de consumo.
                h.- Ayudar al usuario a satisfacer sus necesidades en la búsqueda de nuevos productos y/o servicios.
                i.- Proporcionar al usuario todo tipo de información de su interés.
                j.- Recabar la información del usuario en la plataforma.
                k.- Ofrecer productos y/o servicios, ya sea de manera física, telefónica, electrónica o por
                cualquier otra tecnología o medio que esté al alcance de COVE CORPORATIVO.
                l.- Respaldar, registrar y/o controlar el registro de las personas que accedan o visiten nuestras
                páginas o tengan acceso a través de nuestro servidor.
                m.- Verificación de la información proporcionada.
                n.- Análisis y comportamiento de mercado.
                o.- Sondeo estadístico interno.
                p.- Determinar la satisfacción, perfil y las necesidades de los clientes y/o usuarios. q.- Cumplir
                con los requerimientos legales aplicables.
                r.- Seguimiento de venta(s) y/o servicio(s) s.- Cobranza y procedimiento de pago.
                t.- Estudio Crediticio.
            </p>
            <strong>FINALIDADES SECUNDARIAS</strong>

            <p class="justify">
                COVE CORPORATIVO tratará sus datos personales para llevar a cabo alguna o todas las finalidades
                secundarias como informarle del lanzamiento o cambios de nuevos productos, bienes,

                servicios, promociones y/o ofertas de acuerdo a sus intereses; realizar estudios sobre hábitos
                de consumo y de mercado, así como para cualquier otra actividad tendiente a promover, mantener,
                mejorar y evaluar los Servicios,

                COVE CORPORATIVO podrá transferir los datos personales que haya recibido y/o recolectado y/o
                llegue a recibir y/o recolectar de sus usuarios a sus subsidiarias y/o afiliadas y/o terceros,
                ya sean nacionales y/o extranjeros, y/o cualquier autoridad competente que así lo solicite para
                llevar a cabo las finalidades descritas en el párrafo que antecede. La transferencia de los
                datos personales del usuario se encuentra limitada a aquellos actos, hechos y/o procedimientos
                que COVE CORPORATIVO requiera implementar a efecto de estar en posibilidad de cumplir con sus
                obligaciones, regulatorias y/o comerciales en el curso ordinario de sus operaciones. Si el
                usuario no manifiesta su oposición para que sus datos personales sean transferidos, se entenderá
                que ha otorgado su más amplio consentimiento para ello.
            </p>

            <strong>DATOS SENSIBLES</strong>

            <p class="justify">El Titular de la Información reconoce y acepta, que debido a su relación con COVE
                CORPORATIVO
                TECNOLÓGICO puede proporcionar “datos personales sensibles”, es decir, aquellos datos personales
                íntimos o cuya realización debida o indebida pueda dar origen a discriminación o conlleve un
                riesgo grave para éste. En el supuesto de que el Titular de la Información proporcione datos del
                tipo de los llamados sensibles, deberá estar de acuerdo en proporcionarlos y dejará a COVE
                CORPORATIVO TECNOLÓGICO libre de cualquier queja o reclamación respectiva.</p>

            <strong>TRANSFERENCIA.</strong>
            <p class="justify">
                COVE CORPORATIVO seleccionarán proveedores que considere confiables y que se comprometan,
                mediante un contrato u otros medios legales aplicables, a implementar las medidas de seguridad
                necesarias para garantizar un nivel de protección adecuado a sus datos personales. Derivado de
                lo anterior COVE CORPORATIVO TECNOLÓGICO, exigirá a sus proveedores que cumplan con medidas de
                seguridad que garanticen los mismos niveles de protección que COVE CORPORATIVO TECNOLÓGICO
                implementa durante el tratamiento de sus datos personales. Estas terceras partes tendrán acceso
                a su información con la finalidad de realizar las tareas especificadas en las finalidades
                primarias.

                Si el titular, no acepta la transmisión de sus datos personales de conformidad con lo estipulado
                en el párrafo anterior, puede ponerse en contacto con COVE CORPORATIVO TECNOLÓGICO, por
                cualquiera de los medios establecidos en el presente Aviso de Privacidad.
            </p>
            <strong>EXCEPCIONES</strong>
            <p class="justify">
                ADICIONALMENTE Y DE CONFORMIDAD CON LO ESTIPULADO EN LOS ARTÍCULOS 10, 37 Y DEMÁS RELATIVOS DE
                LA LEY Y SU REGLAMENTO, COVE CORPORATIVO QUEDARA EXCEPTUADO DE LAS OBLIGACIONES REFERENTES AL
                CONSENTIMIENTO PARA EL TRATAMIENTO Y TRANSFERENCIA DE SUS DATOS, CUANDO:
            </p>
            <p class="justify">
                I. Esté previsto en una Ley;
                II. Los datos figuren en fuentes de acceso público;
                III. Los datos personales se sometan a un procedimiento previo de disociación;
                IV. Tenga el propósito de cumplir obligaciones derivadas de una relación jurídica entre el titular y
                el responsable;
                V. Exista una situación de emergencia que potencialmente pueda dañar a un individuo en su persona o
                en sus bienes;
                VI. Sean indispensables para la atención médica, la prevención, diagnóstico, la prestación de
                asistencia sanitaria, tratamientos médicos o la gestión de servicios sanitarios;
                VII. Se dicte resolución de autoridad competente;
                VIII. Cuando la transferencia sea precisa para el reconocimiento, ejercicio o defensa de un derecho
                en un proceso judicial, y
                IX. Cuando la transferencia sea precisa para el mantenimiento o cumplimiento de una relación
                jurídica entre el responsable y el titular.
            </p>
            <strong>DERECHO ARCO</strong>
            <p class="justify">
                Usted podrá en todo momento ejercer los derechos de acceso, rectificación, cancelación y
                oposición de sus datos personales (“Derechos ARCO”), limitar el uso y divulgación de sus datos
                personales, así como revocar el consentimiento otorgado para el tratamiento de los mismos. La
                solicitud que usted como usuario efectúe, deberá contener por lo menos su nombre, domicilio
                completo, teléfono, dirección, documentos que acrediten su identidad y especificar en forma
                clara y precisa los datos personales de los que solicita su acceso, rectificación, actualización
                o los elementos o documentos en donde pueden obrar los datos personales e indicar las razones
                por las cuales desea acceder a sus datos personales, o las razones por las que considera que sus
                datos deben ser actualizados, rectificados o cancelados.
            </p>
            <strong>MEDIO Y PROCEDIMIENTO PARA EJERCER “DERECHOS ARCO” Y/O REVOCACIÓN DE CONSENTIMIENTO PARA EL
                TRATAMIENTO DE DATOS PERSONALES</strong>
            <p class="justify">
                Usted o su representante legal podrá ejercer cualquiera de los derechos de acceso,
                rectificación, cancelación u oposición (en lo sucesivo “Derechos ARCO”), así como revocar su
                consentimiento para el tratamiento de sus datos personales enviando un correo electrónico al
                Departamento de Datos Personales de COVE CORPORATIVO a la dirección http://www.enera.mx donde se
                le atenderá en tiempo y forma.
            </p>
            <strong>MEDIDAS DE SEGURIDAD.-</strong>
            <p class="justify">
                COVE CORPORATIVO TECNOLÓGICO S.A. DE C.V., cuenta con medidas de seguridad de manera
                administrativa y técnicas para el manejo correcto sus Datos Personales.
            </p>
            <p class="justify">
                Entre dichos mecanismos y medidas, se encuentran la suscripción de cartas y convenios de
                confidencialidad de colaboradores y empleados, a través de las cuales dichas personas se
                comprometen a tratar los datos personales del autorizante de manera lícita y aplicable en cuanto
                a las finalidades para las cuales fueron proporcionados, para lo cual estamos comprometidos a
                guardar confidencialidad en el manejo de los mismos.
            </p>
            <p class="justify">
                Entre las medidas de seguridad administrativas y técnicas para el manejo correcto de sus Datos
                Personales se encuentra:
            </p>
            1.- Protocolo de selección de personal.
            2.- Protocolo de uso de información.
            3.- Protocolo de seguridad interno por triangulación, consistente en el acceso diferenciado de tres
            niveles de acceso, para identificar al usuario interno, a través del cual se restringe y/o vigila
            y/o controla y/o limita y/o supervisa el acceso a la información.
            4.- Protocolo de alta y baja de usuarios.

            <strong>USO DE COOKIES Y WEB BEACONS</strong>
            <p class="justify">
                Las cookies son archivos de texto que son descargados automáticamente y almacenados en el disco
                duro del equipo de cómputo del usuario al navegar en una página de Internet específica, que
                permiten recordar al servidor de internet algunos datos sobre este usuario, entre ellos, sus
                preferencias para la visualización de las páginas en ese servidor, nombre y contraseña. Por su
                parte las web beacons son imágenes insertadas en una página de internet o correo electrónico,
                que puede ser utilizado para monitorear el comportamiento de un visitante, como almacenar
                información sobre la dirección IP del usuario, duración del tiempo de interacción en dicha
                página y el tipo de navegador utilizado, entre otros.
            </p>
            Le informamos que utilizamos cookies y web beacons para obtener información personal de usted, como
            la siguiente:

            <ul>
                <li>Su tipo de navegador y sistema operativo</li>
                <li>Las páginas de internet que visita</li>
                <li>Los vínculos que sigue</li>
                <li>La dirección IP</li>
                <li>El sitio que visitó antes de entrar al nuestro</li>
            </ul>
            <p class="justify">
                Estas cookies y otras tecnologías pueden ser deshabilitadas. Para conocer cómo hacerlo por favor
                consulte la sección de ayuda de su navegador específico.
            </p>
            <strong>MEDIO PARA COMUNICAR CAMBIOS AL AVISO DE PRIVACIDAD.</strong>
            <p class="justify">
                COVE CORPORATIVO se reserva el derecho, bajo su exclusiva discreción, de cambiar, modificar,
                agregar o eliminar partes del presente Aviso de Privacidad en cualquier momento. En tal caso,
                COVE CORPORATIVO publicará dichas modificaciones en el sitio web http://www.enera.mx e indicará
                la fecha de última versión del aviso. Le recomendamos visitar periódicamente esta página con la
                finalidad de informarse si ocurre algún cambio al presente.
            </p>
            <p class="justify">
                Para cualquier duda en materia de privacidad de datos que le competa al Departamento de Datos
                Personales de COVE CORPORATIVO, por favor envíe un correo electrónico a http://www.enera.mx y
                con gusto será atendido (a).
            </p>
            <p class="justify">
                Última actualización marzo del 2014.
            </p>

            <strong>ATENTAMENTE</strong>
            <p class="justify">
                COVE CORPORATIVO TECNOLÓGICO S.A. DE C.V.
            </p>
            <p class="justify">
                AVISO DE PRIVACIDAD SIMPLIFICADO: COVE CORPORATIVO TECNOLÓGICO S.A. DE C.V.., es una Sociedad
                Mexicana debidamente constituida con domicilio en Av. Vallarta 6503 local E-16 Plaza Concentro,
                Ciudad Granja Zapopan Jalisco, México, C.P. 45010.
                http://www.enera.mx

                , quien es responsable del tratamiento de sus datos personales. Los datos

                personales que usted proporcione, serán tratados conforme a nuestras políticas de privacidad,
                mismo que puede consultar

                en el sitio

                AVISO DE CONFIDENCIALIDAD Y CONFIABILIDAD: La información contenida en el presente correo, sólo
                debe ser leída

                por la/s persona/s destinatario(s), ya que puede contener material estrictamente confidencial.
                Cualquier impresión,

                retransmisión, difusión u otro uso que se le dé a esta información y que no se haya autorizado
                queda estrictamente

                prohibido. Si usted recibió este mensaje por error, por favor de contactar al emisor y borrar su
                contenido.

                De las Infracciones y Sanciones

                Artículo 63.- Constituyen infracciones a esta Ley, las siguientes conductas llevadas a cabo por
                el responsable:

                I. No cumplir con la solicitud del titular para el acceso, rectificación, cancelación u
                oposición al tratamiento de sus datos personales, sin razón fundada, en los términos previstos
                en esta Ley;

                II. Actuar con negligencia o dolo en la tramitación y respuesta de solicitudes de acceso,
                rectificación, cancelación u oposición de datos personales;

                III. Declarar dolosamente la inexistencia de datos personales, cuando exista total o
                parcialmente en las bases de datos del responsable;

                IV. Dar tratamiento a los datos personales en contravención a los principios establecidos en la
                presente Ley;

                V. Omitir en el aviso de privacidad, alguno o todos los elementos a que se refiere el artículo
                16 de esta Ley;

                VI. Mantener datos personales inexactos cuando resulte imputable al responsable, o no efectuar
                las rectificaciones o cancelaciones de los mismos que legalmente procedan cuando resulten
                afectados los derechos de los titulares;

                VII. No cumplir con el apercibimiento a que se refiere la fracción I del artículo 64; VIII.
                Incumplir el deber de confidencialidad establecido en el artículo 21 de esta Ley;

                IX. Cambiar sustancialmente la finalidad originaria del tratamiento de los datos, sin observar
                lo dispuesto por el artículo 12;

                X. Transferir datos a terceros sin comunicar a éstos el aviso de privacidad que contiene las
                limitaciones a que el titular sujetó la divulgación de los mismos;

                XI. Vulnerar la seguridad de bases de datos, locales, programas o equipos, cuando resulte
                imputable al responsable;

                XII. Llevar a cabo la transferencia o cesión de los datos personales, fuera de los casos en que
                esté permitida por la Ley;

                XIII. Recabar o transferir datos personales sin el consentimiento expreso del titular, en los
                casos en que éste sea exigible;

                XIV. Obstruir los actos de verificación de la autoridad; XV. Recabar datos en forma engañosa y
                fraudulenta;

                XVI. Continuar con el uso ilegítimo de los datos personales cuando se ha solicitado el cese del
                mismo por el Instituto o los titulares;

                XVII. Tratar los datos personales de manera que se afecte o impida el ejercicio de los derechos
                de acceso, rectificación, cancelación y oposición establecidos en el artículo 16 de la
                Constitución Política de los Estados Unidos Mexicanos;

                XVIII. Crear bases de datos en contravención a lo dispuesto por el artículo 9, segundo párrafo
                de esta Ley, y

                XIX. Cualquier incumplimiento del responsable a las obligaciones establecidas a su cargo en
                términos de lo previsto en la presente Ley.

                Artículo 64.- Las infracciones a la presente Ley serán sancionadas por el Instituto con:

                I. El apercibimiento para que el responsable lleve a cabo los actos solicitados por el titular,
                en los términos previstos por esta Ley, tratándose de los supuestos previstos en la fracción I
                del artículo anterior;

                II. Multa de 100 a 160,000 días de salario mínimo vigente en el Distrito Federal, en los casos
                previstos en las fracciones II a VII del artículo anterior;

                III. Multa de 200 a 320,000 días de salario mínimo vigente en el Distrito Federal, en los casos
                previstos en las fracciones VIII a XVIII del artículo anterior, y

                IV. En caso de que de manera reiterada persistan las infracciones citadas en los incisos
                anteriores, se impondrá una multa adicional que irá de 100 a 320,000 días de salario mínimo
                vigente en el Distrito Federal. En tratándose de infracciones cometidas en el tratamiento de
                datos sensibles, las sanciones podrán incrementarse hasta por dos veces, los montos
                establecidos.

                Artículo 65.- El Instituto fundará y motivará sus resoluciones, considerando: I. La naturaleza
                del dato;

                II. La notoria improcedencia de la negativa del responsable, para realizar los actos solicitados
                por el titular, en términos de esta Ley;

                III. El carácter intencional o no, de la acción u omisión constitutiva de la infracción;

                IV. La capacidad económica del responsable, y

                V. La reincidencia.

                Artículo 66.- Las sanciones que se señalan en este Capítulo se impondrán sin perjuicio de la
                responsabilidad civil o penal que resulte.

                CAPÍTULO XI
                De los Delitos en Materia del Tratamiento Indebido de Datos Personales

                Artículo 67.- Se impondrán de tres meses a tres años de prisión al que estando autorizado para
                tratar datos personales, con ánimo de lucro, provoque una vulneración de seguridad a las bases
                de datos bajo su custodia.

                Artículo 68.- Se sancionará con prisión de seis meses a cinco años al que, con el fin de
                alcanzar un lucro indebido, trate datos personales mediante el engaño, aprovechándose del error
                en que se encuentre el titular o la persona autorizada para transmitirlos.

                Artículo 69.- Tratándose de datos personales sensibles, las penas a que se refiere este Capítulo
                se duplicarán.
            </p>

            <!-- termina términos y condiciones-->
        </div>

        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
    <!-- Modal términos y condiciones -->


    <!-- ads
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!— Anuncio Adaptable —>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-7906422245182015"
         data-ad-slot="2591062884"
         data-ad-format="auto"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
     ads -->


@stop

@section('footer')


    <div class="footer-copyright">
        <div class="container">
            <!--
                        <img src="https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/logo_pie_enera_alto.png"
                             alt="" class="footer-logo left">-->

            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')


    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}
    {!! HTML::script('js/welcome.js') !!}
    {!! HTML::script('js/ajax/logs.js') !!}

    <script>
        var myLog = new logs();



        $(document).ready(function ()
        {

            //welcome loaded
            var loadedJson = {
                _token: "{!! session('_token') !!}",
                client_mac: "{!! $client_mac !!}"
            };

            myLog.welcomeLoaded(loadedJson, function()
            {
                //success
                console.log("Success log welcome_loaded");
            },
            function(){
                //fail
                console.log("Fail log welcome_loaded");

            });


        });

        var clicked = false;

        function showLoader(loaderId)
        {
            if (!clicked)
            {
                clicked=true;
                $("#" + loaderId).css("opacity", "1");

                var data={
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };

                myLog.joined(data, fbRedirect, logFail);

            }
        }

        function fbRedirect()
        {
            console.log("Success log joined");
            window.location.replace( "{!! HTML::decode($login_response) !!}");
        }

        function logFail()
        {
            console.log("Fail log joined, retrying...");

            //retry log
            var data={
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            };

            myLog.joined(data, fbRedirect, logFail);
        }


    </script>
@stop