<?php 
$pageTitle = __("page.about",true);
$pageDescription = __("page.about.description",true);
$pageIcon = 'icon-about.gif';
$this->set('title_for_layout', $pageTitle);
echo $this->element('sub_header',array(
    'icon'=>$pageIcon,
    'title'=>$pageTitle,
    'description'=>$pageDescription,
));
?>

<style type="text/css">
table#hr-about td {
	padding: 4px;
	vertical-align: top;
}
table#hr-about h2 {
	margin-bottom: 10px;
}
table#hr-about td li,
table#hr-about td p {
 	line-height: 20px;
	font-size: 14px;
	color: #333;
}
table#hr-about td h4 {
	color: #ffffff;
	margin: 0px;
	padding: 0px;
	font-size: 14px;
}
</style>

<table id="hr-about" style="width:920px;margin-right: auto;margin-left:auto;">
    <tr>
        <td colspan="2" style="padding-left:100px;padding-bottom: 20px;">
            <video id="hr-intro-movie" controls="controls" 
                    src="<?=Configure::Read('Server.URL').'theme/monterrey/files/CDHFINAL.m4v'?>" 
                    poster="<?=Configure::Read('Server.URL').'theme/monterrey/img/intro-video-poster.jpg'?>" 
                    height="480" width="720">
            </video>
            <script type="text/javascript"> 
            jwplayer("hr-intro-movie").setup({
                flashplayer: "<?=Configure::Read('Server.URL').'swf/jwplayer.swf'?>"
            });
            </script>
        </td>
    </tr>
    <tr>
    	<td>
    		<h2>¡Bienvenido!</h2>
    		<p>
    		Este es un espacio abierto a todos y todas para la difusión de actos de civilidad y solidaridad cívica que, grandes o pequeños, son igual de relevantes para nuestra comunidad.
    	 	</p>
    	 	<h2>¿Que es Crónicas de Héroes Monterrey?</h2>
    	 	<p>
    	 	Es parte de una amplia campaña de pensamiento positivo sobre Monterrey. A través de una plataforma basada en internet, pretendemos destacar la actitud positiva de todos aquellos habitantes de la ciudad -niños y niñas, jóvenes y adultos- que efectúan estas acciones día con día. 
    	 	</p>
    	</td> 	
        <td>
        	<h2>¿Cuál es el objetivo de Crónicas de Héroes Monterrey?</h2>
			<p>
			Buscamos inyectar energía positiva y optimismo a nuestra ciudad. Es un esfuerzo por alimentar el espíritu de solidaridad cívica y de lucha que ha distinguido a Monterrey en los momentos difíciles de su historia, apuntalando "el orgullo de ser del Norte" y el amor por la ciudad que siempre ha distinguido a sus habitantes. Deseamos mostrar al mundo que éstas son las principales características de nuestra sociedad. 
			</p>
        </td>
    </tr>
    <tr>
        <td>
        <p><b>
		Invitamos a todos en Monterrey y su área metropolitana a narrar historias de generosidad desinteresada, altruismo y amabilidad, sin importar lo sencillo o pequeño que éstas pudieran parecer. Cada historia hace una diferencia en nuestra vida.
        </b></p>
        </td>
        <td>
        <p><b>
		Queremos leer de los héroes cotidianos: la persona que le cede su asiento a una señora embarazada en el transporte público; el que ayuda en un accidente de tráfico o el que auxilia al niño lastimado.
         </b></p>
        </td>
    </tr>
    <tr>
        <td><h2>¿Quiénes somos?</h2>
        <p>
		Somos un grupo de ciudadanos residentes en el área metropolitana que deseamos contribuir a hacer de Monterrey una sociedad que reconoce el altruismo de sus miembros ante las difíciles condiciones que han venido marcando a la ciudad en tiempos recientes. Con este objetivo, solicitamos al <a href="http://civic.mit.edu">MIT Center for Civic Media</a> incorporar a Monterrey como Partner Community dentro de la red global de comunidades <a href="http://www.heroreports.org/">Hero Reports</a>.         
        </p>
        <p>
		Crónicas de Héroes Monterrey es un proyecto sin fines de lucro, apartidista y sin ninguna afiliación religiosa o relación con algún programa de gobierno; su creación y financiamiento es gracias a la aportación voluntaria y desinteresada de integrantes de la sociedad civil de Monterrey.
        </p>
        </td>
        <td><h2>¿Qué puedes hacer</h2>
        	<p>
        	¡Si sabes de un acto heroico, cuéntaselo a todos! Crónicas de Héroes Monterrey ofrece un lugar para que TÚ puedas narrar aquellos actos -hasta ahora desconocidos- de heroísmo civil, grandes o pequeños, de los que has sido testigo o has escuchado: acciones de solidaridad, de civismo, de ayuda desinteresada, contribuciones a la sociedad y a nuestro medio ambiente. 
			</p>
			<p>
			Entra a la sección de Cuéntanos y escribe, en forma breve, la historia que quieras compartir con tu comunidad. Sólo te pedimos que permanezcan anónimos las personas o los datos específicos de los hechos: lo que importa es la acción cívica que puede hacer a cada una y uno de nosotros un héroe. 
        	</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <h2>Acuerdos para la participación</h2>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <p>
		<ul>
		<li>Para cuidar la calidad editorial de las historias y el anonimato de los actores, 
			el Comité Editorial de Crónicas de Héroes Monterrey no publicará en este sitio 
			cualquier narración que contenga lenguaje ofensivo, fuera de contexto o que incluya 
			los nombres o datos de personas específicas. Esto aplica también a los datos 
			específicos del autor de la narración. Si eres el autor de una Crónica que no ha 
			aparecido en la galería de Crónicas, escribe a info@mty.cronicasdeheroes.mx para 
			solicitar una explicación.
		</li>
		<li>Las Crónicas que aparecen en este sitio son la expresión de cada habitante de 
			Monterrey; no expresan de manera alguna las opiniones o puntos de vista sobre 
			cualquier tema de quienes colaboran en el proyecto. 
		</li>
		<li>En relación a los contenidos de las narraciones que tú aportes y que pudieran 
			eventualmente tener algún derecho de propiedad intelectual (fotos, videos y textos), 
			como usuario y contribuyente de este sitio aceptas que Crónicas de Héroes Monterrey 
			tiene tu consentimiento para utilizar este material a nivel local o global y que no 
			habrá retribución alguna por tu participación.
		</li>
		</ul>
		</p>
        </td>
    </tr>

</table>