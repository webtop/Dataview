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

/* Partials/header.html.twig */
class __TwigTemplate_a32250d9c343bde47f45cd0a75fe7220 extends Template
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
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->displayBlock('header', $context, $blocks);
    }

    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "    ";
        if ((($context["db_loaded"] ?? null) == false)) {
            // line 3
            echo "        ";
            $this->loadTemplate("Forms/db_connect.html.twig", "Partials/header.html.twig", 3)->display($context);
            // line 4
            echo "    ";
        } else {
            // line 5
            echo "        This is the header area!
    ";
        }
    }

    public function getTemplateName()
    {
        return "Partials/header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  54 => 5,  51 => 4,  48 => 3,  45 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% block header %}
    {%  if db_loaded == false %}
        {%  include 'Forms/db_connect.html.twig' %}
    {%  else %}
        This is the header area!
    {% endif %}
{% endblock %}", "Partials/header.html.twig", "/var/www/html/src/View/Partials/header.html.twig");
    }
}
