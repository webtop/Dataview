<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* Layouts/main.html.twig */
class __TwigTemplate_baf54ba6ac33eaf0a502387ae33d5ef9 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'header' => [$this, 'block_header'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>";
        // line 5
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <link rel=\"stylesheet\" href=\"/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/css/main.css\">
</head>
<body class=\"container\">

    <header>
        <div class=\"row mt-4\">
            <div class=\"col-md-12\">
                ";
        // line 15
        $this->displayBlock('header', $context, $blocks);
        // line 18
        echo "            </div>
        </div>
    </header>

    <div id=\"main\" class=\"mt-4\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                ";
        // line 25
        $this->displayBlock('content', $context, $blocks);
        // line 28
        echo "            </div>
        </div>
    </div>

    <footer>
        <div class=\"row\">
            <div class=\"col-md-12\">
                ";
        // line 35
        $this->displayBlock('footer', $context, $blocks);
        // line 38
        echo "            </div>
        </div>
    </footer>

    <script src=\"/js/bootstrap.bundle.js\"></script>
    <script src=\"/js/jquery-3.6.0.min.js\"></script>
    <script src=\"/js/main.js\"></script>
</body>
</html>";
    }

    // line 15
    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        echo "                    ";
        $this->loadTemplate("Partials/header.html.twig", "Layouts/main.html.twig", 16)->display($context);
        // line 17
        echo "                ";
    }

    // line 25
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 26
        echo "                    This seems to be working
                ";
    }

    // line 35
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 36
        echo "                    ";
        $this->loadTemplate("Partials/footer.html.twig", "Layouts/main.html.twig", 36)->display($context);
        // line 37
        echo "                ";
    }

    public function getTemplateName()
    {
        return "Layouts/main.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  122 => 37,  119 => 36,  115 => 35,  110 => 26,  106 => 25,  102 => 17,  99 => 16,  95 => 15,  83 => 38,  81 => 35,  72 => 28,  70 => 25,  61 => 18,  59 => 15,  46 => 5,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>{{ title }}</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <link rel=\"stylesheet\" href=\"/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"/css/main.css\">
</head>
<body class=\"container\">

    <header>
        <div class=\"row mt-4\">
            <div class=\"col-md-12\">
                {% block header %}
                    {% include 'Partials/header.html.twig' %}
                {% endblock %}
            </div>
        </div>
    </header>

    <div id=\"main\" class=\"mt-4\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                {% block content %}
                    This seems to be working
                {% endblock %}
            </div>
        </div>
    </div>

    <footer>
        <div class=\"row\">
            <div class=\"col-md-12\">
                {% block footer %}
                    {% include 'Partials/footer.html.twig' %}
                {% endblock %}
            </div>
        </div>
    </footer>

    <script src=\"/js/bootstrap.bundle.js\"></script>
    <script src=\"/js/jquery-3.6.0.min.js\"></script>
    <script src=\"/js/main.js\"></script>
</body>
</html>", "Layouts/main.html.twig", "/var/www/html/src/View/Layouts/main.html.twig");
    }
}
