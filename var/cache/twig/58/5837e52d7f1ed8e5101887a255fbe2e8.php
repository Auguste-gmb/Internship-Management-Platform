<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* errors/404.html.twig */
class __TwigTemplate_6567831a1c2d23e92f1d81cd96b15fbd extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 2
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 4
        $context["active"] = "";
        // line 2
        $this->parent = $this->load("base.html.twig", 2);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "StageHub — Page introuvable";
        yield from [];
    }

    // line 8
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 9
        yield "<nav>
  <a href=\"index.html\" class=\"nav-logo\">Stage<span>Hub</span></a>
  <div class=\"nav-links\" id=\"navLinks\">
    <a href=\"index.html\">Accueil</a>
    <span class=\"sep\">|</span>
    <a href=\"offer.html\">Offres</a>
    <span class=\"sep\">|</span>
    <a href=\"entreprises.html\">Entreprises</a>
    <span class=\"sep\">|</span>
    <a href=\"dashboard.html\">Dashboard</a>
  </div>
  <div class=\"nav-right\">
    <a href=\"login-register.html\" class=\"btn-login\">Connexion</a>
    <div class=\"nav-avatar\" aria-label=\"Profil\">
      <svg viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z\"/></svg>
    </div>
    <div class=\"nav-hamburger\" id=\"hamburger\"><span></span><span></span><span></span></div>
  </div>
</nav>

<div class=\"page-404\">
  <div class=\"err-illustration\">
    <svg width=\"180\" height=\"160\" viewBox=\"0 0 180 160\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
      <rect x=\"30\" y=\"55\" width=\"120\" height=\"85\" rx=\"10\" fill=\"#fff\" stroke=\"#ebebeb\" stroke-width=\"2\"/>
      <rect x=\"30\" y=\"44\" width=\"60\" height=\"20\" rx=\"6\" fill=\"#dff0ec\" stroke=\"#ebebeb\" stroke-width=\"2\"/>
      <line x1=\"72\" y1=\"82\" x2=\"108\" y2=\"118\" stroke=\"#e89080\" stroke-width=\"5\" stroke-linecap=\"round\"/>
      <line x1=\"108\" y1=\"82\" x2=\"72\" y2=\"118\" stroke=\"#e89080\" stroke-width=\"5\" stroke-linecap=\"round\"/>
      <circle cx=\"138\" cy=\"40\" r=\"22\" fill=\"#fff\" stroke=\"#6bbfb0\" stroke-width=\"3\"/>
      <line x1=\"154\" y1=\"56\" x2=\"168\" y2=\"70\" stroke=\"#6bbfb0\" stroke-width=\"4\" stroke-linecap=\"round\"/>
      <text x=\"130\" y=\"48\" font-family=\"Nunito, sans-serif\" font-weight=\"900\" font-size=\"20\" fill=\"#6bbfb0\">?</text>
    </svg>
  </div>

  <div class=\"err-code\">404</div>
  <h1 class=\"err-title\">Page introuvable</h1>
  <p class=\"err-sub\">Oups ! La page que vous cherchez n'existe pas ou a été déplacée. Pas de panique, votre stage idéal vous attend ailleurs !</p>

  <div class=\"err-btns\">
    <a href=\"index.html\" class=\"btn-primary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><path d=\"M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z\"/><polyline points=\"9 22 9 12 15 12 15 22\"/></svg>
      Retour à l'accueil
    </a>
    <a href=\"offer.html\" class=\"btn-secondary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/></svg>
      Voir les offres
    </a>
    <a href=\"javascript:history.back()\" class=\"btn-secondary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><polyline points=\"15 18 9 12 15 6\"/></svg>
      Page précédente
    </a>
  </div>

  <p style=\"color:#bbb;font-size:.8rem;font-weight:700;margin-top:48px\">
    Vous pensez que c'est une erreur ?
    <a href=\"mailto:contact@stagehub.fr\" style=\"color:var(--salmon);text-decoration:none;font-weight:800\">Contactez-nous</a>
  </p>
</div>

<script>
document.getElementById('hamburger').addEventListener('click', () => {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('navLinks').classList.toggle('open');
});
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "errors/404.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  73 => 9,  66 => 8,  55 => 6,  50 => 2,  48 => 4,  41 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/errors/404.html.twig #}
{% extends 'base.html.twig' %}

{% set active = '' %}

{% block title %}StageHub — Page introuvable{% endblock %}

{% block body %}
<nav>
  <a href=\"index.html\" class=\"nav-logo\">Stage<span>Hub</span></a>
  <div class=\"nav-links\" id=\"navLinks\">
    <a href=\"index.html\">Accueil</a>
    <span class=\"sep\">|</span>
    <a href=\"offer.html\">Offres</a>
    <span class=\"sep\">|</span>
    <a href=\"entreprises.html\">Entreprises</a>
    <span class=\"sep\">|</span>
    <a href=\"dashboard.html\">Dashboard</a>
  </div>
  <div class=\"nav-right\">
    <a href=\"login-register.html\" class=\"btn-login\">Connexion</a>
    <div class=\"nav-avatar\" aria-label=\"Profil\">
      <svg viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z\"/></svg>
    </div>
    <div class=\"nav-hamburger\" id=\"hamburger\"><span></span><span></span><span></span></div>
  </div>
</nav>

<div class=\"page-404\">
  <div class=\"err-illustration\">
    <svg width=\"180\" height=\"160\" viewBox=\"0 0 180 160\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
      <rect x=\"30\" y=\"55\" width=\"120\" height=\"85\" rx=\"10\" fill=\"#fff\" stroke=\"#ebebeb\" stroke-width=\"2\"/>
      <rect x=\"30\" y=\"44\" width=\"60\" height=\"20\" rx=\"6\" fill=\"#dff0ec\" stroke=\"#ebebeb\" stroke-width=\"2\"/>
      <line x1=\"72\" y1=\"82\" x2=\"108\" y2=\"118\" stroke=\"#e89080\" stroke-width=\"5\" stroke-linecap=\"round\"/>
      <line x1=\"108\" y1=\"82\" x2=\"72\" y2=\"118\" stroke=\"#e89080\" stroke-width=\"5\" stroke-linecap=\"round\"/>
      <circle cx=\"138\" cy=\"40\" r=\"22\" fill=\"#fff\" stroke=\"#6bbfb0\" stroke-width=\"3\"/>
      <line x1=\"154\" y1=\"56\" x2=\"168\" y2=\"70\" stroke=\"#6bbfb0\" stroke-width=\"4\" stroke-linecap=\"round\"/>
      <text x=\"130\" y=\"48\" font-family=\"Nunito, sans-serif\" font-weight=\"900\" font-size=\"20\" fill=\"#6bbfb0\">?</text>
    </svg>
  </div>

  <div class=\"err-code\">404</div>
  <h1 class=\"err-title\">Page introuvable</h1>
  <p class=\"err-sub\">Oups ! La page que vous cherchez n'existe pas ou a été déplacée. Pas de panique, votre stage idéal vous attend ailleurs !</p>

  <div class=\"err-btns\">
    <a href=\"index.html\" class=\"btn-primary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><path d=\"M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z\"/><polyline points=\"9 22 9 12 15 12 15 22\"/></svg>
      Retour à l'accueil
    </a>
    <a href=\"offer.html\" class=\"btn-secondary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/></svg>
      Voir les offres
    </a>
    <a href=\"javascript:history.back()\" class=\"btn-secondary-sm\">
      <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\" style=\"width:16px;height:16px\"><polyline points=\"15 18 9 12 15 6\"/></svg>
      Page précédente
    </a>
  </div>

  <p style=\"color:#bbb;font-size:.8rem;font-weight:700;margin-top:48px\">
    Vous pensez que c'est une erreur ?
    <a href=\"mailto:contact@stagehub.fr\" style=\"color:var(--salmon);text-decoration:none;font-weight:800\">Contactez-nous</a>
  </p>
</div>

<script>
document.getElementById('hamburger').addEventListener('click', () => {
  document.getElementById('hamburger').classList.toggle('open');
  document.getElementById('navLinks').classList.toggle('open');
});
</script>
{% endblock %}", "errors/404.html.twig", "/var/www/stagehub.fr/templates/errors/404.html.twig");
    }
}
