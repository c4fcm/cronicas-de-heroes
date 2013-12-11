<?php 
$pageTitle = __("page.about",true);
$this->set('title_for_layout', $pageTitle);
//¿Qué son Crónicas de Héroes?/What are Cronicas de Heroes?
$inEnglish = (Configure::Read('Config.language')=="eng-tjsd");
?>

<?php 
if($inEnglish) {
?>

<h3>Project Background</h3>
<p>
September 11th showed us we're vulnerable. We are not immune to war; we are part of the battleground. But its horror also showed us our strength. That a city scared to death can be courageous. We all can be heroes. The New York Metropolitan Transit Authority understood that an alert public is our most important asset, they created a campaign of citizen surveillance: If You See Something Say Something. The campaign organized by the Secretariat seeks the cooperation of society by being alert and by reporting any suspicious activity. But if we just focus on negative acts, society can lose its balance. Also, promoting and spreading fear can affect community values and damage the social fabric. In response, New Yorkers and the MIT Media Center created a counter-campaign called Hero-Reports. This campaign sought peace and called for change based on values of compassion, strength, dialogue which can create the necessary strength and the basis for a responsible and active society. Currently in cities along the border of Mexico and the United States the violence and crime have taken the place of optimism, however good deeds also happen, for this reason in Tijuana / San Diego, we want to implement this campaign and to document the positive acts from the every day.
</p>

<h3>What are CRÓNICAS DE HÉROES Tijuana/San Diego?</h3>
<p>
CRÓNICAS DE HÉROES is a campaign of positive thinking that reports civic courage as an example of collaboration of civil society. It gives to the people a place where they can make public and share with others those small acts of kindness, respect, honesty and other positive contributions to society.  
</p>
Tijuana-San Diego is the first bi-national platform for this initiative; it aims to transform the perception of U.S.A.-Mexican border societies and reignite civic pride as well as hope in those communities. The campaign builds on its recent success in Juárez, México and intends to replicate its model in several U.S.A.-México border regions.  
<p>
CRÓNICAS DE HÉROES represents a host of opportunities where the different systems and mechanism, organizations, institutions, and everyday citizens from both sides of the border can employ the initiative as a tool for civic pride, dialogue and collaboration. Through this platform individuals can share many stories reflecting similar values, culture, needs, interest, and concerns with their ”other” neighbors and hopefully overcome the geographic and political boundaries separating them. 
</p>
<p>
The voice of each individual translated in these positive stories through the mixture of media offered by the initiative will positively reframe the image of these border regions both nationally and internationally as well as their citizens’ perspective.
</p>

<h3>What can you do? If you see something report it and make it public!!</h3>
<p>
The world is scary, but our vision and our words, can still carry the choice of humanity. Hero Reports asks YOU to report moments that show our human side and acknowledge those positive actions that happen every day. These reports can be small acts of kindness, such as giving up a seat for a pregnant woman,  or reporting an organization that is making positive changes in the region, or to a large heroic actions as helping victims in a car accident. Every day we face our ability to engage, making note these acts can make a big difference in our mental, cultural, social, image, etc.
</p>

<h3>What would we do?</h3>
<p>
On the CRÓNICAS DE HÉROES page your  report of a good deed and/ or heroism will be put on a map, this will indicate what border neighborhoods report more positive events, this as a way to join forces and understand the social fabric. Also CRÓNICAS DE HÉROES lead us to believe that truth is also the side of those who stand out for their altruism, for those who are doing their job well and on time, for taking care of their own and others. No matter how small the positive action is, still counts, it is necessary at this time to show that the citizens of this region are a community willing to growth, ready for change and believe in positive values.
</p>

<?php
} else {
?>

<h2><?=$pageTitle?></h2>

<h3>Antecedentes del Proyecto</h3>
<p>
En Nueva York, tras el ataque a las Torres Gemelas del 11 de Septiembre, muchos neoyorquinos se sintieron aterrorizados: eran vulnerables ante una violencia y un enemigo invisible que no comprendían. Pero ese miedo también les mostró su fuerza. Una ciudad que ha sido atemorizada, puede ser valiente. Todos podemos ser héroes. Las autoridades de Nueva York crearon una campana de vigilancia ciudadana: Si Ves Algo, Dí Algo. La campaña convocada por esta secretaria buscaba la colaboración de la sociedad; pedía que esta estuviera alerta y que reportara cualquier acto sospechoso o negativo. Pero si solo nos enfocamos en este tipo de actos, como sociedad podemos perder el balance. Asimismo, el promover o difundir miedo puede llegar afectar a la comunidad y al tejido social. En respuesta, los neoyorquinos y el Centro de Medios de MIT crearon una contra-campaña llamada Hero-Reports. Esta campaña buscaba la paz y convocaba a empezar un cambio basado en valores de compasión, fortaleza, dialogo que puedieran crear la fuerza necesaria y las bases para una sociedad responsable y activa. Actualmente la violencia ha tomado el lugar del optimismo en las ciudades fronterizas entre México y Estados Unidos, por esta razón en Tijuana/ San Diego queremos igualmente implantar esta campaña de positivismo, y documentar las buenas acciones que también suceden día con día.
</p>

<h3>¿Qué son CRÓNICAS DE HÉROES Tijuana/San Diego?</h3>
<p>
CRÓNICAS DE HÉROES es una campaña de positivismo que reporta el valor ciudadano actual, como un ejemplo de colaboración positiva de la sociedad civil. Esta le da a la gente un lugar donde pueden dar a conocer y compartir con otros actos de amabilidad, respeto, honestidad y otras contribuciones positivas a la sociedad.
</p>
<p>
Tijuana-San Diego es la primera plataforma bi-nacional de esta iniciativa, con ella se pretende transformar la percepción de las sociedades de la frontera E.U.A.-México y reavivar el orgullo cívico, así como la esperanza en estas comunidades. La campaña se basa en su reciente éxito en Juárez, México y tiene la intención de replicar su modelo en varias regiones de la frontera E.U.A.-México.
</p>
<p>
CRÓNICAS DE HÉROES, representa una gran oportunidad en la cual  los diferentes sistemas y mecanismos, organizaciones, instituciones e igualmente los ciudadanos de ambos lados de la frontera puedan emplear la iniciativa como una herramienta para el orgullo cívico, el diálogo y la colaboración. A través de esta plataforma las personas pueden compartir muchas historias que reflejan valores, cultura, necesidades, intereses y preocupaciones similares a  las de sus "otros" vecinos; esta iniciativa desea superar los límites geográficos y políticos que los separa.
</p>
<p>
La  voz de cada individuo traducida en estas historias positivas y representadas a través de diversos medios de comunicación ofrecidos por esta iniciativa asistirán en recuperar la imagen positiva de estas regiones fronterizas, tanto a nivel nacional e internacional, así como la perspectiva de sus propios ciudadanos.
</p>

<h3>¿Qué puedes hacer tú?  Si vez algo repórtalo y hazlo público!</h3>
<p>
Aunque el ambiente se vuelva atemorizante, nuestra visión y nuestras palabras pueden crear un clima de humanidad. CRÓNICAS DE HÉROES te pide A TI, que reportes los momentos que muestran nuestro lado humano y reconocer a aquellas acciones positivas que suceden día con día. Los reportes pueden ser sobre pequeños actos positivos, como cederle el asiento a una mujer embarazada en el transporte público, o reportar alguna organización que está haciendo cambios positivos en la región, o hasta grandes gestos heroicos como ayudar a víctimas en un accidente de auto. Cada día nos confrontamos a nuestra capacidad de involucramiento, el hacer notar estos actos puede hacer una gran diferencia en nuestro estado mental, cultural, social, de imagen, etc. 
</p>

<h3>¿Qué haremos nosotros?</h3>
<p>
En la página de CRÓNICAS DE HÉROES se pueden poner las buenas acciones y el heroísmo en un mapa, indicar qué colonias de la frontera reportan más actos positivos como una manera de acercarnos y entendernos mejor como ciudad. Asimismo las CRÓNICAS DE HÉROES nos llevan a creer que la verdad también está del lado de quienes se destacan por su altruismo, por hacer su trabajo bien y a tiempo, por cuidar de los suyos y de los demás. Cada acción positiva por muy pequeña que esta sea debe de contar, es necesario en este momento demostrar que los ciudadanos de esta región son una comunidad dispuesta a engrandeces, lista para un cambio y que cree en los valores positivos. 
</p>

<?php } ?>
