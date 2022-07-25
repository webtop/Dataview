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

/* Forms/db_connect.html.twig */
class __TwigTemplate_45b541f5b8cc9f48d87e41f476698e31 extends Template
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
        echo "<form class=\"row row-cols-lg-auto align-content-center\" id=\"db_connect\">
    <div class=\"col\">
        <label class=\"text-center\" for=\"server\">Server IP: </label>
        <input type=\"text\" class=\"form-control\" id=\"server\" name=\"server\" placeholder=\"localhost or 127.0.0.1\" value=\"localhost\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"username\">Username: </label>
        <input type=\"text\" class=\"form-control\" id=\"username\" name=\"username\" placeholder=\"dataview\" value=\"dataview\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"password\">Password: </label>
        <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" value=\"QnQbB8000\$10\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"database\">Database: </label>
        <input type=\"text\" class=\"form-control\" id=\"database\" name=\"database\" placeholder=\"classicmodels\" value=\"classicmodels\">
    </div>
    <div class=\"col\">
        <button type=\"button\" class=\"btn btn-primary\" id=\"test\">Test Connection</button>
    </div>
    <div class=\"col\">
        <button type=\"submit\" class=\"btn btn-primary\" id=\"connect\">Connect</button>
    </div>
</form>";
    }

    public function getTemplateName()
    {
        return "Forms/db_connect.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<form class=\"row row-cols-lg-auto align-content-center\" id=\"db_connect\">
    <div class=\"col\">
        <label class=\"text-center\" for=\"server\">Server IP: </label>
        <input type=\"text\" class=\"form-control\" id=\"server\" name=\"server\" placeholder=\"localhost or 127.0.0.1\" value=\"localhost\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"username\">Username: </label>
        <input type=\"text\" class=\"form-control\" id=\"username\" name=\"username\" placeholder=\"dataview\" value=\"dataview\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"password\">Password: </label>
        <input type=\"password\" class=\"form-control\" id=\"password\" name=\"password\" value=\"QnQbB8000\$10\">
    </div>
    <div class=\"col\">
        <label class=\"text-center\" for=\"database\">Database: </label>
        <input type=\"text\" class=\"form-control\" id=\"database\" name=\"database\" placeholder=\"classicmodels\" value=\"classicmodels\">
    </div>
    <div class=\"col\">
        <button type=\"button\" class=\"btn btn-primary\" id=\"test\">Test Connection</button>
    </div>
    <div class=\"col\">
        <button type=\"submit\" class=\"btn btn-primary\" id=\"connect\">Connect</button>
    </div>
</form>", "Forms/db_connect.html.twig", "/var/www/html/src/View/Forms/db_connect.html.twig");
    }
}
