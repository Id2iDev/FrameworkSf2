#Framework Symfony 2.6

##Présentation
Ce framewok est principalement développé pour les besoins de mon entreprise, mais également pour mes projets persos.

##Composition
Il est composé de plusieurs parties divisées en plusieurs bundles:


* CMS:
    * [PageBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/CMS/PageBundle) _CMS simplifié (affichage de pages)_
* Core:
    * [AdminLteBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/AdminLteBundle) _Interface de l'administration, prévu pour pouvoir etre remplacé_
    * [CoreBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/CoreBundle) _Sans lui rien ne fonctionne_
    * [DashBoardBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/DashBoardBundle) _Accueil de la partie backoffice_
    * [MediaBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/MediaBundle) _Deviendra à terme le gestionnaire des medias du projet (ne sert pas ou peu pour le moment)_
    * [MultisiteBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/MultisiteBundle) _Permet en fonction du domaine de redirigé le site vers tel ou tels affichage et donc contenu_
    * [NodeBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/NodeBundle) _A terme, tout sera lié à un node_
    * [PlacementBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/PlacementBundle) _Gestionnaire de place sur un theme_
    * [UserBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/UserBundle) _Gestion un peu plus avancée des utilisateurs FosUserBundle_
* ECommerce
    * vide
* Tools
    * [CommuneBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/CommuneBundle) _Gestionnaire de communes françaises_
    * [ContactFormBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/ContactFormBundle) _Surcharge du bundle [mremi/ContactBundle](https://github.com/mremi/ContactBundle)_
    * [FormsBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/FormsBundle) _by Nicolas, je dois aller voir ce qu'il fait_
    * HtmlTemplating _by Nicolas, je dois aller voir ce qu'il fait_
        * [PaginationBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/HtmlTemplating/PaginationBundle) _by Nicolas, je dois aller voir ce qu'il fait_
        * [PaginationBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/HtmlTemplating/PaginationBundle) _by Nicolas, je dois aller voir ce qu'il fait_
    * [PubliciteBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/PubliciteBundle) _un petit crud pour afficher des publicités_
    * [ServiceBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/ServiceBundle) _by Nicolas, je dois aller voir ce qu'il fait_
    * [ThemeBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Tools/ThemeBundle) _gestionnaire de theme en fonction du projet_