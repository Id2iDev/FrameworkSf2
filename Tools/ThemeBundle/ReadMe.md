#Gestion de thème en fonction du domaine du projet

##Pré-requis
Ce Bundle nécéssite [MultiSiteBundle](https://github.com/pkshetlie/FrameworkSf2/tree/master/Core/MultiSiteBundle)
##Installation
il faut ajouter le bundle au kernel :
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Id2i\Tools\ThemeBundle\ThemeBundle(),
    );
}
```
modifier legèrement la configuration
```yml
// app/config.yml
assetic:
    bundles:        [ThemeBundle]
```

##Utilisation
Pour utiliser la surcharge de theme, il vous suffit dans vos bundles de mettre en extends ``ThemeBundle:Default:index.html.twig`` 

exemple:

```yml
{% extends "ThemeBundle:Default:index.html.twig" %}
{% block content %}
Bonjour
{% endblock %}
```
Enfin pour ajouter votre theme perso, il vous faut créer un nouveau Bundle, prenons comme example le bundle FooBundle et le thème Foo configuré dans le  MultiSiteBundle:

cela nous donnera l'arborescence suivante : 
* src/
  * FooBundle/
    * Controller/...
    * DependencyInjection/...
    * Resources/
        * public/
            * Foo/
                * css/
                * js/
                * ...
        * views/
            * Foo/
                * layout.html.twig
    * FooBundle.php

Editez FooBundle.php :
```php
<?php
// src/FooBundle.php
namespace FooBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
class FooBundle extends Bundle
{
    public function getParent(){
        return 'ThemeBundle';
    }
}
?>
```
Et enfin n'oubliez pas d'ajouter votre Bundle au kernel 

```<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Id2i\Tools\ThemeBundle\ThemeBundle(),
    );
}```
##Fonctionnement

Lorsque vous appellez ``ThemeBundle:Default:index.html.twig`` lui même appelle ``ThemeBundle:Default:layout.html.twig`` si aucun site n'est parametré, dans le cas contraire il appellera : ``ThemeBundle:<nom du theme perso>:layout.html.twig`` 
aperçu du fichier layout.html.twig de base 
```twig
<!-- ThemeBundle:Default:layout.html.twig -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{% block title %}Default Theme{% endblock %}</title>
    {% block stylesheets %}{% endblock %}
    {% block metas %}{% endblock %}
    <meta name="description" content="{% block seoDescription %}{% endblock %}"/>
    <meta name="keywords" content="{% block seoKeywords %}{% endblock %}"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
</head>
{% block body %}
    <body>
    {% block content %}{% endblock %}
    </body>
{% endblock %}
{% block javascripts %}
    {% javascripts '@ThemeBundle/Resources/public/default/js/*.min.js' %}
    <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
    {% javascripts '@ThemeBundle/Resources/public/default/js/jquery_need/*.min.js' %}
    <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}
</html>
```