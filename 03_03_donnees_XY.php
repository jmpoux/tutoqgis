<?php include('head.inc.php'); ?>

<body>
<div id="wrap">
	<?php include('menus_horizontaux.inc.php'); ?>
	
	<div id="container_main_sidebar">

		<div class="backgrounds">
			<div class="main"></div>
			<div class="sidebar"></div>
		</div>	
	
		<div class="main">
			<h2>III.3  Ajout de données ponctuelles à partir d'un fichier texte</h2>
				<ul class="listetitres">
					<li><a href="#III31">Qu'y a-t-il dans le fichier texte ?</a></li>
					<li><a href="#III32">Visualisation des données dans QGIS</a>
						<ul class="listesoustitres">
							<li><a href="#III32a">Ajout d'une couche avec un SCR inconnu : préparer le terrain</a>
							<li><a href="#III32b">Visualisation des données sous QGIS</a>
						</ul>
					</li>
					<li><a href="#III33">Création du shapefile de points</a></li>
				</ul>
	
			<p>Nous avons vu quelques pistes pour rechercher et afficher des données au format SIG dans QGIS, que ce soit en les téléchargeant ou via des flux. Il arrive aussi de disposer d'un tableau avec deux colonnes X et Y : comment utiliser ces données dans un SIG ?</p>
			<p>Nous prendrons ici l'exemple d'un fichier au <a class="ext" target="_blank" href="http://fr.wikipedia.org/wiki/Comma-separated_values">format CSV</a>. Pour information, il est possible de créer un fichier au format CSV à partir d'un fichier ODS (LibreOffice) ou XLS (Microsoft Office) par exemple.</p>
			
			<h3><a class="titre" id="III31">Qu'y a-t-il dans le fichier texte?</a></h3>
				
				<div class="manip">
					<p>Dans l'explorateur de votre ordinateur, ouvrez le fichier <em class="data">villes_bhutan_geonames.csv</em> situé dans le dossier <b>TutoQGIS_03_RechercheDonnees/donnees</b> à l'aide d'un éditeur de texte simple (<b>pas dans un tableur</b>) : par exemple, WordPad dans Windows, TextEdit sous Mac, gedit sous Ubuntu.</p>
					<figure>
						<a href="illustrations/tous/3_3_apercu_csv.png" >
							<img src="illustrations/tous/3_3_apercu_csv.png" alt="capture d'écran du fichier CSV" width="600">
						</a>
					</figure>
				</div>
				<p>Le format CSV est un format relativement simple : il contient des colonnes séparées habituellement par des virgules, parfois par des points-virgules, tabulations ou autre. La première ligne contient les en-têtes de colonnes.</p>
				<div class="manip">
					<div class="question">
						<input type="checkbox" id="faq-1">
						<p><label for="faq-1">Combien de colonnes y a-t-il dans le fichier  <em class="data">villes_bhutan_geonames.csv</em> ?</label></p>
						<p class="reponse">Le fichier comporte 9 colonnes : geonamesid, name, asciiname, latitude, longitude, country code, population, dem et modification date.</p>
						<p class="reponse"><img src="illustrations/tous/3_3_csv_colonnes.png" alt="capture d'écran des données du CSV avec les noms de colonnes encadrés en rouge" width="600"></p>
					</div>
					<div class="question">
						<input type="checkbox" id="faq-2">
						<p><label for="faq-2">Quelle est la latitude de la ville de Timphu?</label></p>
						<p class="reponse">La latitude de la ville de Timphu est 27.46609 (la colonne "latitude" est la 4ème colonne : la réponse se trouve donc dans la 4ème colonne de la ligne correspondant à Timphu.</p>
						<p class="reponse"><img src="illustrations/tous/3_3_lat_timphu.png" alt="capture d'écran des données du CSV avec la latitude de Timphu encadrée en rouge" width="460"></p>
					</div>
					<div class="question">
						<input type="checkbox" id="faq-3">
						<p><label for="faq-3">A quoi correspond la colonne "dem" ? Pouvez-vous trouver la réponse dans les métadonnées ?</label></p>
						<p class="reponse">En vous rendant sur http://download.geonames.org/export/dump/readme.txt dans un navigateur internet, vous pouvez lire la définition suivante pour la colonne dem (dans la partie "The main 'geoname' table has the following fields" ) : <b>digital elevation model, srtm3 or gtopo30, average elevation of 3''x3'' (ca 90mx90m) or 30''x30'' (ca 900mx900m) area in meters, integer. srtm processed by cgiar/ciat.</b></p>
						<p class="reponse">Il s'agit donc de la valeur d'un <a class="ext" target="_blank" href="http://fr.wikipedia.org/wiki/Mod%C3%A8le_num%C3%A9rique_de_terrain" >modèle d'élévation numérique</a>, correspondant approximativement à l'altitude. Différents modèles ont été utilisés, à différentes résolutions. </p>
					</div>
					<p>Fermez le fichier sans enregistrer les éventuelles modifications, quittez l'éditeur de texte.</p>
				</div>
				<p>Ce fichier contient donc une liste de villes du <a class="ext" target="_blank" href="http://fr.wikipedia.org/wiki/Bhoutan" >Bhoutan</a>, avec pour chaque ville différentes informations telles que sa population, son élévation, sa latitude et sa longitude.</p>
				<div class="manip">
					<div class="question">
						<input type="checkbox" id="faq-4">
						<p><label for="faq-4">A votre avis, dans quel SCR sont mesurées la latitude et la longitude? Pouvez-vous trouver cette info dans les métadonnées?</label></p>
						<p class="reponse">Comme précisé dans le fichier de métadonnées, les coordonnées sont mesurées en degrés décimaux dans le SCR WGS84.</p>
						<p class="reponse">Dans le cas d'un fichier avec des coordonnées en latitude et longitude et un SCR inconnu, il s'agit fréquemment de coordonnées en WGS84.</p>
					</div>
				</div>
	
			
			<h3><a class="titre" id="III32">Visualisation des données dans QGIS</a></h3>
				
				<h4><a class="titre" id="III32a">Ajout d'une couche avec un SCR inconnu : préparer le terrain</a></h4>
				
					<p>Dans la mesure où nous allons ajouter des données issues d'un fichier texte à QGIS, QGIS ne pourra pas lire dans quel SCR ont été mesurées ces coordonnées : ce sera à nous de le préciser au logiciel.</p>
					<div class="manip">
						<p>Lancez QGIS si ce n'est pas déjà fait, ou bien créez un nouveau projet sans sauvegarder l'ancien.</p>
						<p>Pour être sûr que QGIS vous demande dans quel SCR sont les coordonnées du fichier texte, rendez-vous dans le menu 
							<a class="thumbnail_bottom" href="#thumb">Préférences  &#8594; Options
								<span>
									<img src="illustrations/tous/2_3_preferences_options_menu.png" alt="Menu Préférences, Options" height="150" >
								</span>
							</a>
							, rubrique <b>SCR</b> :
						</p>
						<figure>
							<a href="illustrations/tous/2_4_options_sans_scr.png" >
								<img src="illustrations/tous/2_4_options_sans_scr.png" alt="Options, rubrique SCR" width="500">
							</a>
						</figure>
						<p>Pour l'option <b>Quand une nouvelle couche est créée ou quand une couche est chargée sans SCR</b>, choisissez l'option <b>Demander le SCR</b> si ce n'est pas déjà fait. Cliquez sur <b>OK</b>.</p>
					</div>
				
				<h4><a class="titre" id="III32b">Visualisation des données sous QGIS</a></h4>
			
				<div class="manip">
					<p><img class="icone" src="illustrations/tous/1_2_ajout_vecteur_icone.png" alt="Icône ajout d'une couche vecteur">A partir de QGIS, chargez la couche <em class="data">ne_10m_admin_0_countries.shp</em> située dans le dossier <b>TutoQGIS_03_RechercheDonnees/donnees</b>.</p>
					<p><img class="icone" src="illustrations/tous/3_3_ajout_csv_icone.png" alt="icône ajout fichier texte délimité" >
						Cliquez sur l'icône <b>Ajouter une couche de texte délimité</b>, ou bien rendez-vous dans le 
						<a class="thumbnail_bottom" href="#thumb">Menu Couche &#8594; Ajouter une couche &#8594; Ajouter une couche de texte délimité
							<span>
								<img src="illustrations/tous/3_3_ajout_csv_menu.png" alt="Menu Couche, ajouter une couche de texte délimité" height="300" >
							</span>
						</a>				
					</p>
					<figure>
						<a href="illustrations/tous/3_3_ajout_csv_fenetre.png" >
							<img src="illustrations/tous/3_3_ajout_csv_fenetre.png" alt="Fenêtre d'ajout d'une couche CSV" width="600">
						</a>
					</figure>
					<ul>
						<li class="espace">Cliquez sur le bouton <b>Parcourir</b> et sélectionnez le fichier <em class="data">villes_bhutan_geonames.csv</em></li>
						<li class="espace"><b>Nom de la couche :</b> vous pouvez laisser <b>villes_bhutan_geonames</b> ou bien tapez le nom de votre choix</li>
						<li class="espace"><b>Format de fichier :</b> choisir <b>CSV (virgule)</b></li>
						<li class="espace"><b>Enregistrements :</b> vérifiez que la case <b>en-têtes de 1ère ligne</b> soit bien cochée</li>
						<li class="espace"><b>Définition de la géométrie : </b> choisir <b>point</b>, puis les colonnes X et Y : <b>longitude et latitude</b></li>		
					</ul>
					<p>Cliquez sur <b>OK</b>. Une fenêtre s'ouvre vous demandant dans quel SCR sont les coordonnées du fichier CSV : choisissez le WGS84, comme vu plus haut.</p>
					<p>Zoomez sur la couche de points et ouvrez sa table attributaire :</p>
					<figure>
						<a href="illustrations/tous/3_3_visu_villes_bhutan.png" >
							<img src="illustrations/tous/3_3_visu_villes_bhutan.png" alt="Visualisation des villes du bhutan et de leurs données attributaires sous QGIS" width="550" >
						</a>
					</figure>
					<p>Les villes ont bien été ajoutées à QGIS sous la forme d'une couche de points.</p>
				</div>		
	
			
			<h3><a class="titre" id="III33">Création du shapefile de points</a></h3>
			
			<p>Regardez <a href="01_02_info_geo.php#I23b">à quel emplacement</a> est stockée votre couche. Vous pouvez observer que cet emplacement fait référence à un fichier CSV et non à un fichier SHP.</p>
			<p>Par ailleurs, si vous sélectionnez la couche de villes dans la table des matières, vous pouvez constater que l'icône pour passer en mode édition est désactivée, au contraire de notre couche de pays. La couche de villes n'est donc pas éditable.</p>
			<p class="note">Icône édition activée : <img class="iconemid" src="illustrations/tous/3_3_edition_icone_activee.png" alt="Icône édition activée" > Icône édition désactivée : <img class="iconemid" src="illustrations/tous/3_3_edition_icone_desactivee.png" alt="Icône édition désactivée" ></p>
			<p>Ces indices laissent à penser que bien que nous puissions visualiser les villes dans QGIS, <b>aucun SHP n'a été créé</b>, ce qui est d'ailleurs logique dans la mesure où QGIS ne nous a demandé à aucun moment de choisir un emplacement pour cette couche.</p>
			<p>En fait, nous avons seulement créé <b>une couche temporaire, uniquement stockée dans le projet QGS en cours</b>. Comment faire pour sauvegarder cette couche?</p>
			
			<div class="manip">
				<p>Il suffit pour cela de faire un
					<a class="thumbnail_bottom" href="#thumb">clic-droit sur la couche <em class="data">villes_bhutan_geonames</em>, Enregistrer sous...
						<span>
							<img src="illustrations/tous/3_3_sauvegarder_villes_menu.png" alt="clic droit sur la couche, sauvegarder sous" height="300" >
						</span>
					</a>
				</p>
				<figure>
					<a href="illustrations/tous/3_3_sauvegarder_villes_fenetre.png" >
						<img src="illustrations/tous/3_3_sauvegarder_villes_fenetre.png" alt="fenêtre de sauvegarde de la couche" width="370" >
					</a>
				</figure>
				<ul>
					<li class="espace">Cliquez sur <b>Parcourir</b> pour sélectionner l'emplacement où la couche sera créée et lui donner un nom</li>
					<li class="espace">Cochez la case <b>Ajouter les fichiers sauvegardés à la carte</b></li>
					<li class="espace">Laissez les autres paramètres par défaut</li>
				</ul>
				<p>Cliquez sur <b>OK</b> ; la couche est ajoutée à QGIS, vous devez donc avoir deux couches de villes identiques au premier abord; cependant, l'une est temporaire et l'autre permanente.</p>
				<p><img class="icone" src="illustrations/tous/3_3_supprimer_couche_icone.png" alt="Icône supprimer une couche" >
					<a class="thumbnail_top" href="#thumb">Supprimez la couche temporaire
						<span>
							<img src="illustrations/tous/3_3_supprimer_couche_menu.png" alt="clic-droit sur la couche, supprimer" height="300" >
						</span>
					</a>	
				 pour éviter toute confusion (en vous aidant éventuellement de son emplacement pour déterminer laquelle est-ce).
				</p>
				<p class="note">En ouvrant la table attributaire de la nouvelle couche, vous pouvez constater que les noms de champs ont été tronqués à 10 caractères (&#171; country co &#187; au lieu de &#171; country code &#187; par exemple). Ceci est une limitation liée au format DBF utilisé pour les <a href="01_03_formats.php#I31a">fichiers shapefile</a>.</p>
				
			</div>
			<p>Félicitations ! L'ajout de données ponctuelles à partir d'un fichier texte dans QGIS n'a désormais plus de secrets pour vous !</p>
	
			<br>
			<a class="prec" href="03_02_donnees_flux.php">chapitre précédent</a>
			<a class="suiv" href="03_04_donnees_osm.php">chapitre suivant</a>
			<br>
			<a class="hautpage" href="#wrap">haut de page</a>						
				
		</div>
		<div class="sidebar">
			<?php include('logos_menus_verticaux.inc.php'); ?>
			<?php include('menus_verticaux_3.inc.php'); ?>
		</div>
		
		<div id="notforprint" style="clear:both;"></div>
	
	</div>

	<?php include('footer.inc.php'); ?>

</div>
</body>
</html>
