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
			<h2>VI.4  Pour aller plus loin : requêtes SQL</h2>
				<ul class="listetitres">
					<li><a href="#VI41">Utiliser du SQL sans passer par un logiciel de bases de données : le concept de couche virtuelle</a>
					<li><a href="#VI42">Effectuer une requête simple avec le gestionnaire de bases de données</a>
					   <ul class="listesoustitres">
							<li><a href="#VI42a">Activer le gestionnaire de bases de données</a></li>
							<li><a href="#VI42b">Ecrire une requête</a></li>
							<li><a href="#VI42c">Visualiser le résultat d'une requête</a></li>
						</ul>
					</li>
					<li><a href="#VI43">Tirer parti du SQL par rapport à une requête attributaire ou spatiale</a>
					   <ul class="listesoustitres">
							<li><a href="#VI43a">Choisir les colonnes</a></li>
							<li><a href="#VI43b">Croiser plusieurs tables</a></li>
							<li><a href="#VI43c">Un peu de spatial</a></li>

						</ul>
					</li>
					<li><a href="#VI44">Effectuer une requête en ajoutant une couche virtuelle</a></li>
				</ul>
				<br>
				
			<p>Nous avons vu dans les chapitres précédents que QGIS offre de nombreux opérateurs pour les requêtes spatiales et attributaires. Néanmoins, ceux d'entre vous maîtrisant le <b><a class="ext" target="_blank" href="https://fr.wikipedia.org/wiki/Structured_Query_Language" >langage SQL</a></b> regretteront certains manques, notamment les <a class="ext" target="_blank" href="http://sql.sh/fonctions/agregation">fonctions d'agrégation</a>. En outre, l'impossibilité d'écrire une requête portant à la fois sur des critères spatiaux et attributaires peut être gênante.</p>
			<p>Une des possibilités pour pallier ces manques est d'utiliser un logiciel de <b>gestion de bases de données</b> (SGBD) à composante spatiale, tel que <a class="ext" target="_blank" href="http://www.postgis.fr/chrome/site/docs/workshop-foss4g/doc/index.html">PostgreSQL/PostGIS</a>, ou <a class="ext" target="_blank" href="http://www.sigterritoires.fr/index.php/tutoriel-bases-de-donnees-spatialite-sous-qgis-2-8-wien/">SQLite/SpatiaLite</a>, ce dont ne traitera pas ce tutoriel.</p>
			<p>Mais si votre but est uniquement de jouir de toutes les possibilités du SQL sans avoir besoin d'une base de données, il existe une autre possibilité consistant à utiliser des <b><a class="ext" target="_blank" href="https://docs.qgis.org/2.14/fr/docs/user_manual/working_with_vector/virtual_layers.html">couches virtuelles</a></b>. Pour cela, aucune installation de logiciel supplémentaire n'est nécessaire.</p>
			<p><b>Cette partie ne constitue pas un cours de SQL</b>, se limitant à expliquer l'interface de QGIS et à montrer quelques exemples. Il existe sur internet de nombreuses ressources sur l'apprentissage du SQL, comme par exemple <a class="ext" target="_blank" href="http://sql.sh/cours/select" >ici</a>.</p>
			
			<h3><a class="titre" id="VI41">Utiliser du SQL sans passer par un logiciel de bases de données : le concept de couche virtuelle</a></h3>
			
			 <p>Les <b>couches virtuelles</b> (virtual layers) sont un type particulier de couches vecteur ne contenant pas de données mais renvoyant vers d'autres couches.</p>
			 <p>Elles permettent d'utiliser le langage SQL sur une ou plusieurs couches vectorielles chargées dans QGIS, au format shapefile ou autre.</p>
			 <p>Pour information, les fonctions SQL disponibles sont celles de <a class="ext" target="_blank" href="https://www.sqlite.org/lang.html">SQLite</a>/<a class="ext" target="_blank" href="http://www.gaia-gis.it/spatialite-2.4.0/spatialite-sql-2.4.html">SpatiaLite</a>.</p>
			
			<h3><a class="titre" id="VI42">Effectuer une requête simple avec le gestionnaire de bases de données</a></h3>
			
			 <p>Une des manières d'utiliser les couches virtuelles dans QGIS est de passer par le <b>gestionnaire de bases de données</b> (DB Manager). Il s'agit d'une extension installée par défaut dans QGIS.</p>
			
				<h4><a class="titre" id="VI42a">Activer le gestionnaire de bases de données</a></h4>
				    <div class="manip">
				        <p>A partir du menu <b>Base de données</b> de QGIS, vérifiez si vous avez accès au sous-menu du 
				        <a class="thumbnail_bottom" href="#thumb">gestionnaire de base de données
                        	<span>
                        		<img src="illustrations/tous/6_4_dbmanager_menu.png" alt="Menu Bases de données, Gestionnaire de bases de données" height="75" >
                        	</span>
                        </a>.</p>
				        <p>Si oui, vous pouvez passer à la <a href="06_04_req_sql.php#VI42b">partie suivante</a>. Si non :</p>
				        <p>Rendez-vous dans le menu <b>Extension &#8594; Installer/Gérer les extensions</b> :</p>
				        <figure>
                        	<a href="illustrations/tous/6_4_dbmanager_activation.png" >
                        		<img src="illustrations/tous/6_4_dbmanager_activation.png" alt="Activation du gestionnaire de bases de données" width="600">
                        	</a>
                        </figure>
                        <p>Dans la rubrique <b>Installées</b>, recherchez l'extension <b>DB Manager</b> et cochez la case correspondante, puis fermez la fenêtre du gestionnaire d'extensions.</p>
				    </div>
					
				<h4><a class="titre" id="VI42b">Ecrire une requête</a></h4>
				
				    <div class="manip">
				        <p>Ouvrez un nouveau projet dans QGIS et ajoutez-y les trois couches shapefile <em class="data">Installations_de_traitement_de_dechets</em>, <em class="data">communes_NordPasdeCalais</em> et <em class="data">departements</em> situées dans le dossier <b>TutoQGIS_06_Requetes/donnees</b></p>
				        <p><img class="icone" src="illustrations/tous/6_4_dbmanager_icone.png" alt="icône gestionnaire de bases de données">Ouvrez la fenêtre du gestionnaire de bases de données : menu <b>Bases de données &#8594; Gestionnaire de bases de données &#8594; Gestionnaire de bases de données</b>, ou bien cliquez sur l'icône correspondante dans la barre d'outils Base de données.</p>
				        <figure>
                        	<a href="illustrations/tous/6_4_dbmanager_fenetre.png" >
                        		<img src="illustrations/tous/6_4_dbmanager_fenetre.png" alt="Fenêtre du gestionnaire de bases de données" width="600">
                        	</a>
                        </figure>
				        <p>Dans l'arborescence située dans la partie gauche de la fenêtre, allez dans <b>Virtual Layers</b> puis dans <b>QGIS layers</b> : vous devriez voir vos 3 couches chargées dans QGIS.</p>
				        <p>Cliquez sur une des couches et allez dans l'onglet <b>Info</b>, dans la partie droite de la fenêtre. Vous pouvez y lire des informations générales sur la couche, un peu comme dans la fenêtre des propriétés, telles que le nombre d'entités, le SCR, la liste des champs.</p>
				        <p>Les onglets <b>Table</b> et <b>Aperçu</b> vous donne respectivement un aperçu des données attributaires et spatiales.</p>
				        <p><img class="icone" src="illustrations/tous/6_4_fenetre_sql_icone.png" alt="icône de la fenêtre SQL" >Cliquez ensuite sur l'icône <b>Fenêtre SQL</b>, ou bien menu <b>Base de données</b> &#8594; <b>Fenêtre SQL</b>.</p>
				        <figure>
                        	<a href="illustrations/tous/6_4_dbmanager_requete.png" >
                        		<img src="illustrations/tous/6_4_dbmanager_requete.png" alt="Ecriture d'une requête dans le gestionnaire de bases de données" width="600">
                        	</a>
                        </figure>
				        <p>Un quatrième onglet s'ajoute, permettant d'écrire une requête SQL (il est possible d'ouvrir ainsi plusieurs onglets de requête SQL).</p>
				        <p>Dans la moitié supérieure de cet onglet, tapez la requête suivante (cette requête sera explicitée en détail un peu plus loin) :</p>
				        <p class="code">select * from departements where "NOM_DEPT" = 'NORD'</p>
				        <p class="note">Vous pouvez utiliser ou non des retours à la ligne, le résultat sera le même.</p>
				        <p>et cliquez sur le bouton <b>Exécuter</b> : le résultat de la requête s'affiche dans la moitié inférieure de la fenêtre.</p>
				    </div>
				    
				<h4><a class="titre" id="VI42c">Visualiser le résultat d'une requête</a></h4>
				    
				    <p>Seule la ligne correspondante de la table attributaire est affichée dans le gestionnaire de bases de données. Comment faire pour voir les géométries correspondantes dans QGIS ?</p>
				    <div class="manip">
				        <figure>
                        	<a href="illustrations/tous/6_4_dbmanager_charger.png" >
                        		<img src="illustrations/tous/6_4_dbmanager_charger.png" alt="Charger le résultat d'un requête dans QGIS" width="600">
                        	</a>
                        </figure>
				        <p>En bas de le fenêtre du gestionnaire, cochez la case <b>Charger en tant que nouvelle couche</b> : une nouvelle rubrique apparaît :
				            <ul>
				                <li>Vérifiez que la colonne de géométrie <b>geometry</b> soit bien sélectionnée</li>
				                <li>Tapez éventuellement un nom pour la nouvelle couche (par défaut, elle se nommera QueryLayer)</li>
				                <li>Et cliquez sur le bouton <b>Charger !</b> pour voir le résultat dans QGIS :</li>
				            </ul>
				        </p>
				        <figure>
                        	<a href="illustrations/tous/6_4_dept_nord.png" >
                        		<img src="illustrations/tous/6_4_dept_nord.png" alt="Résultat de la requête (département du Nord) chargé dans QGIS" width="600">
                        	</a>
                        </figure>
				    </div>
				    <p>Notez que la nouvelle couche est une couche temporaire, non éditable. Pour la sauvegarder, il faut faire un clic droit sur son nom dans QGIS, Enregistrer sous.</p>
				    <p>Par ailleurs, si dans la fenêtre du gestionnaire de bases de données vous actualisez la liste des couches virtuelles, vous verrez cette nouvelle couche y apparaître.</p>
		
			<h3><a class="titre" id="VI43">Tirer parti du SQL par rapport à une requête attributaire ou spatiale</a></h3>
			
			    <p>La requête utilisée était :</p>
			    <p class="code">select * from departements where "NOM_DEPT" = 'NORD'</p>
			    <p>A quoi correspond cette requête ? Regardons-la ligne par ligne :</p>
		        <p class="code">select *</p>
		        <p>signifie que nous allons sélectionner (<b>select</b>) toutes (la mention <b>*</b>) les colonnes de la table attributaire, ainsi que la géométrie, qui est considérée comme une colonne nommée geometry, comme vous pouvez le vérifier dans l'onglet <b>Info</b>.</p>
		        <p class="code">from departements</p>
		        <p>signifie que nous allons sélectionner les colonnes de la couche <em class="data">departements</em>.</p>
		        <p class="code">where "NOM_DEPT" = 'NORD'</p>
		        <p>applique un critère à la requête : seules seront sélectionnées les lignes répondant à ce critère, c'est-à-dire dont la valeur pour le champ NOM_DEPT est égale à &#171;&nbsp;Nord&nbsp;&#187;.</p>
			    <p>Comparons avec <a href="06_01_req_attrib.php#VI11">la même requête dans la fenêtre de requête attributaire</a>, où seul le critère <b>"NOM_DEPT" = 'NORD'</b> est nécessaire, le début de la requête étant &#171;&nbsp;sous-entendu&nbsp;&#187;.</p>
			    <p>Par rapport à une requête attributaire, une requête SQL nous offre donc la possibilité :
			        <ul>
			            <li>de choisir les colonnes qui nous intéressent</li>
			            <li>d'effectuer des requêtes sur la géométrie</li>
			            <li>de croiser plusieurs tables</li>
			        </ul></p>  
			        
			    <h4><a class="titre" id="VI43a">Choisir les colonnes</a></h4>
			         <p>Pour que le résultat de la requête ne comporte que les colonnes voulues, il suffit de les lister dans la requête.</p>
			         <div class="manip">
			             <figure>
                        	<a href="illustrations/tous/6_4_colonnes.png" >
                        		<img src="illustrations/tous/6_4_colonnes.png" alt="Choix des colonnes dans la requête SQL" width="600">
                        	</a>
                        </figure>
			             <p>Toujours dans l'onglet <b>Requête</b> du gestionnaire de bases données, remplacez l'étoile par <b>CODE_DEPT, NOM_DEPT, geometry</b> :</p>
			             <p class="code">select CODE_DEPT, NOM_DEPT, geometry from departements where "NOM_DEPT" = 'NORD'</p>
			             <p>Et cliquez sur le bouton <b>Exécuter</b> : seules les colonnes voulues sont renvoyées par la requête.</p>
			         </div>
			         <p>Comme précédemment, vous pouvez si vous le désirez charger ce résultat dans QGIS en tant que nouvelle couche.</p>
			         
			    <h4><a class="titre" id="VI43b">Croiser plusieurs tables</a></h4>
			     
			         <p>Comment faire si nous voulons maintenant croiser plusieurs tables, par exemple obtenir pour chaque commune de la couche <em class="data">communes_NordPasDeCalais</em> le nom du chef-lieu du département correspondant dans la couche <em class="data">departements</em> ?</p>
			         <div class="manip">
			             <p>La première étape est de vérifier qu'il existe bien un champ permettant de faire le lien entre les deux couches. Ici, il s'agit  du champ <b>CODE_DEPT</b> présent dans les deux couches, ce que vous pouvez vérifier en ouvrant leurs tables attributaires (à noter que ce champ pourrait avoir un nom différent dans chacune des couches sans que ça ne pose problème).</p>
			             <p>Tapez ensuite la requête suivante (vous pouvez effacer la précédente) :</p>
			             <p class="code">select c.INSEE_COM, c.NOM_COMM, d.NOM_CHF, c.geometry from communes_NordPasDeCalais as c, departements as d where c.NOM_DEPT = d.NOM_DEPT</p>
			             <figure>
                        	<a href="illustrations/tous/6_4_croiser_couches.png" >
                        		<img src="illustrations/tous/6_4_croiser_couches.png" alt="Exemple de requête SQL croisant deux couches" width="600">
                        	</a>
                        </figure>
                        <p>Le résultat s'affiche : une ligne par commune, avec les colonnes choisies. Par rapport à la couche originale de communes, une information provenant de la couche de départements a été ajoutée, le nom du chef-lieu.</p>
                     </div>
                    <p>Prenons cette requête ligne par ligne (mais dans le désordre !) :</p>
                    <p class="code">from communes_NordPasDeCalais as c, departements as d</p>
                    <p>signifie deux choses : que les deux couches en jeu seront <em class="data">communes_NordPasDeCalais</em> et <em class="data">departements</em>, et que dans le reste de la requête, les noms de ces deux couches seront abrégés respectivement en <b>c</b> et <b>d</b>.</p>
                    <p>Cette abréviation des noms de couches n'est pas obligatoire ; elle permet néanmoins de taper moins de texte, et de gagner en clarté. Un autre avantage est que si vous deviez réutiliser cette requête pour d'autres couches, vous n'aurier à modifier qu'une seule fois leur nom.</p>
                    <p class="code">select c.INSEE_COM, c.NOM_COMM, d.NOM_CHF, c.geometry</p>
                    indique quelles colonnes vont être récupérées. Comme il est possible qu'une colonne existe dans les deux couches (cas de <b>geometry</b> ici), le nom abrégé de la table (<b>c</b> ou <b>d</b>) est indiqué devant. Même si cette désambiguïsation n'est pas toujours nécessaire (pour <b>INSEE_COM</b> par exemple), il est conseillé de toujours indiquer le nom de la couche pour des raisons de clarté.
                    <p class="code">where c.NOM_DEPT = d.NOM_DEPT</p>
                    <p>permet au logiciel de savoir comment faire le lien entre les lignes des tables des deux couches. Il s'agit de l'équivalent d'une <a href="08_01_jointure_attrib.php" >jointure attributaire</a>.</p>
                    <p>Il est donc possible de faire intervenir dans une même requête autant de couches que vous le désirez, à condition de pouvoir faire le lien entre ces couches (dernière ligne de la requête).</p>
			     
			         
			     <h4><a class="titre" id="VI43c">Un peu de spatial</a></h4>
			         
			         <p>Comment est-il possible d'utiliser la colonne de géométrie ? Essayons par exemple de sélectionner les communes contenant des installations de traitement de déchets, comme déjà réalisé précédemment au moyen d'une <a href="06_02_req_spatiales.php#VI21" >requête spatiale</a>.</p>
			         <div class="manip">
			         	 <p>Pour rappel, croiser deux couches est plus facile si elles sont dans le même SCR (même s'il est possible de modifier le SCR en SQL directement dans la requête !). Chargez la couche d'installations de traitements de déchets en RGF93 Lambert93 créée <a href="06_02_req_spatiales.php#VI21a" >précédemment</a>, ou bien si vous avez sauté cette étape <a href="02_04_changer_systeme.php#II42">modifiez le SCR de cette couche</a> pour qu'elle soit comme la couche de communes en RGF93 Lambert93.</p>
			             <p>Nous pouvons déjà écrire les deux premières lignes de notre requête, par exemple :</p>
			             <p class="code">select c.INSEE_COM, c.NOM_COMM from communes_NordPasDeCalais as c, installations_dechets as i</p>
			             <p>mais il nous manque le critère spatial indiquant que les communes doivent contenir au moins une installation.</p>
			             <p>Une recherche dans la <a class="ext" target="_blank" href="http://www.gaia-gis.it/spatialite-2.4.0/spatialite-sql-2.4.html" >liste des fonctions SpatiaLite</a> et plus spécifiquement dans la partie consacrée aux <a class="ext" target="_blank" href="http://www.gaia-gis.it/spatialite-2.4.0/spatialite-sql-2.4.html#p12">fonctions testant les relations spatiales</a> nous permet de trouver l'opérateur <b>Contains</b> et de compléter notre requête :</p>
			             <p class="code">where Contains(c.geometry, i.geometry)</p>
			             <p>ce qui se traduit par : la géométrie des communes doit contenir la géométrie des installations.</p>
                        <p>Exécutez la requête et ajoutez le résultat dans QGIS :</p>
			             <figure>
                        	<a href="illustrations/tous/6_4_contains.png" >
                        		<img src="illustrations/tous/6_4_contains.png" alt="Exemple de requête SQL spatiale croisant deux couches et aperçu du résultat" width="600">
                        	</a>
                        </figure>
                        <p class="note">Si la requête ne renvoie pas de résultat, vérifiez que vous appelez bien la couche d'installations qui est en Lambert 93.</p>
			         </div>
			         <p>Il existe de nombreux opérateurs spatiaux que vous pouvez vous amuser à tester. Il est bien sûr possible d'ajouter des critères spatiaux et attributaires dans une même requête.</p>
			     
			
			<h3><a class="titre" id="VI44">Effectuer une requête en ajoutant une couche virtuelle</a></h3>
			
			 <p>Nous avons vu comment écrire une requête SQL à partir du gestionnaire de bases de données. Il existe une autre interface possible, celle de la fenêtre d'ajout/édition de couche virtuelle/</p>
			 <div class="manip">
			     <p><img class="icone" src="illustrations/tous/6_4_ajout_vl_icone.png" alt="icône Ajouter/Editer une couche virtuelle" >Menu 
			     <a class="thumbnail_bottom" href="#thumb">Couche &#8594; Ajouter une couche &#8594; Ajouter/Editer une couche virtuelle
                	<span>
                		<img src="illustrations/tous/6_4_ajout_vl_menu.png" alt="Menu couche, ajouter une couche, ajouter/éditer une couche virtuelle" height="500" >
                	</span>
                </a>, ou bien cliquez sur l'icône correspondante.
                    <figure>
                    	<a href="illustrations/tous/6_4_ajout_vl_fenetre.png" >
                    		<img src="illustrations/tous/6_4_ajout_vl_fenetre.png" alt="Fenêtre d'ajout/édition d'une couche virtuelle avec un exemple de requête" width="420">
                    	</a>
                    </figure>
                    <ul>
                        <li class="espace"><b>Nom de la couche :</b> il s'agit du nom qu'aura la couche virtuelle</li>
                        <li class="espace"><b>Requête :</b> la dernière requête tapée dans le gestionnaire de bases de données s'affiche automatiquement. Si ce n'est pas le cas, tapez une requête de votre choix</li>
                        <li class="espace"><b>Géométrie :</b> Autodétecter laisse au logiciel le soin de déterminer quelle est la colonne de géométrie. Il est également possible de spécifier <b>Aucune géométrie</b> si la couche n'en contient pas, ou bien de spécifier manuellement la colonne de géométrie</li>
                        <li class="espace"><b>Test :</b> ce bouton permet de détecter les éventuelles erreurs présentes dans la requête</li>
                        <li class="espace"><b>OK :</b> exécute la requête et ajoute le résultat dans QGIS.</li>
                    </ul>
                </p>
                <p>Vous devriez obtenir une couche temporaire similaire à celle créée précédemment.</p>
			 </div>
			 
			<p>Dans cette fenêtre, la rubrique <b>Couche intégrées</b> permet de lister les couches présentes dans QGIS (bouton <b>Importer</b>) ou bien d'autres couches non chargées (bouton <b>Ajouter</b>).</p>
			<p>Cette fenêtre permet donc globalement la même chose que le gestionnaire de bases de données, avec une interface un peu différente. A vous de choisir celle que vous préférez !</p>
			 
				
		<br>
		<a class="prec" href="06_03_req_combinees.php">chapitre précédent</a>
		<a class="suiv" href="07_00_champs.php">partie VII : calcul de champs</a>
		<br>
		<a class="hautpage" href="#wrap">haut de page</a>					
				
		</div>
		<div class="sidebar">
			<?php include('logos_menus_verticaux.inc.php'); ?>
			<?php include('menus_verticaux_6.inc.php'); ?>
		</div>
		
		<div id="notforprint" style="clear:both;"></div>
	
	</div>

	<?php include('footer.inc.php'); ?>

</div>
</body>
</html>
