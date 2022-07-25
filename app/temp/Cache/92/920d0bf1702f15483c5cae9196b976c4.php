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

/* Partials/db_conn_test.html.twig */
class __TwigTemplate_d44dc655ccfbb07395a3ae4bb776f996 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<span id=\"loaded_state\">";
        echo twig_escape_filter($this->env, ($context["db_loaded"] ?? null), "html", null, true);
        echo "</span>
<span id=\"connect_message\">";
        // line 2
        echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
        echo "</span>";
    }

    public function getTemplateName()
    {
        return "Partials/db_conn_test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<span id=\"loaded_state\">{{ db_loaded }}</span>
<span id=\"connect_message\">{{ message }}</span>", "Partials/db_conn_test.html.twig", "/var/www/html/src/View/Partials/db_conn_test.html.twig");
    }
}
