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

/* base.html.twig */
class __TwigTemplate_487cbe71113de4d1fad6f9ece16c944f extends Template
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

        $this->parent = false;

        $this->blocks = [
            'meta_desc' => [$this, 'block_meta_desc'],
            'title' => [$this, 'block_title'],
            'extra_css' => [$this, 'block_extra_css'],
            'body_class' => [$this, 'block_body_class'],
            'content' => [$this, 'block_content'],
            'extra_js' => [$this, 'block_extra_js'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"fr\">
<head>
  <meta charset=\"UTF-8\"/>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
  <meta name=\"description\" content=\"";
        // line 6
        yield from $this->unwrap()->yieldBlock('meta_desc', $context, $blocks);
        yield "\"/>
  <title>";
        // line 7
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
  <link
    href=\"https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap\"
    rel=\"stylesheet\"
  />
  <link rel=\"stylesheet\" href=\"/assets/css/style.css\"/>
  ";
        // line 13
        yield from $this->unwrap()->yieldBlock('extra_css', $context, $blocks);
        // line 14
        yield "</head>
<body class=\"";
        // line 15
        yield from $this->unwrap()->yieldBlock('body_class', $context, $blocks);
        yield "\">

";
        // line 20
        yield "<nav>
  <a href=\"/\" class=\"nav-logo\">Stage<span>Hub</span></a>

  <div class=\"nav-links\" id=\"navLinks\">
    <a href=\"/\"            ";
        // line 24
        if ((($context["active"] ?? null) == "home")) {
            yield "class=\"active\"";
        }
        yield ">Accueil</a>
    <span class=\"sep\" aria-hidden=\"true\">|</span>
    <a href=\"/offres\"      ";
        // line 26
        if ((($context["active"] ?? null) == "offres")) {
            yield "class=\"active\"";
        }
        yield ">Offres</a>
    <span class=\"sep\" aria-hidden=\"true\">|</span>
    <a href=\"/entreprises\" ";
        // line 28
        if ((($context["active"] ?? null) == "entreprises")) {
            yield "class=\"active\"";
        }
        yield ">Entreprises</a>

    ";
        // line 30
        if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 31
            yield "      <span class=\"sep\" aria-hidden=\"true\">|</span>
      <a href=\"/dashboard\" ";
            // line 32
            if ((($context["active"] ?? null) == "dashboard")) {
                yield "class=\"active\"";
            }
            yield ">Dashboard</a>
    ";
        }
        // line 34
        yield "  </div>

  <div class=\"nav-right\">
    ";
        // line 37
        if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 38
            yield "      ";
            // line 39
            yield "      <span class=\"nav-username\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["app_user"] ?? null), "prenom", [], "any", false, false, false, 39), "html", null, true);
            yield "</span>

      ";
            // line 42
            yield "      ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["app_user"] ?? null), "role", [], "any", false, false, false, 42) == "administrator")) {
                // line 43
                yield "        <span class=\"nav-badge nav-badge--admin\">Admin</span>
      ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source,             // line 44
($context["app_user"] ?? null), "role", [], "any", false, false, false, 44) == "pilote")) {
                // line 45
                yield "        <span class=\"nav-badge nav-badge--pilote\">Pilote</span>
      ";
            }
            // line 47
            yield "
      <a href=\"/deconnexion\" class=\"btn-login\">Déconnexion</a>
    ";
        } else {
            // line 50
            yield "      <a href=\"/connexion\" class=\"btn-login\">Connexion</a>
    ";
        }
        // line 52
        yield "
    ";
        // line 54
        yield "    ";
        if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 55
            yield "      <a href=\"/profil\" aria-label=\"Mon profil\">
        <div class=\"nav-avatar\">
          <svg viewBox=\"0 0 24 24\" fill=\"currentColor\" aria-hidden=\"true\">
            <path d=\"M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4
                     7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6
                     1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z\"/>
          </svg>
        </div>
      </a>
    ";
        }
        // line 65
        yield "
    <button class=\"nav-hamburger\" id=\"hamburger\" aria-label=\"Menu\" aria-expanded=\"false\">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

";
        // line 75
        yield "<main id=\"main-content\">
  ";
        // line 76
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 77
        yield "</main>

";
        // line 82
        yield "<footer>
  <div class=\"footer-grid\">

    <div class=\"footer-brand\">
      <h3>Stage<span>Hub</span></h3>
      <p>La plateforme de mise en relation entre étudiants CESI et entreprises partenaires.</p>
    </div>

    <div class=\"footer-col\">
      <h4>Navigation</h4>
      <ul>
        <li><a href=\"/\">Accueil</a></li>
        <li><a href=\"/offres\">Offres de stage</a></li>
        <li><a href=\"/entreprises\">Entreprises</a></li>
        ";
        // line 96
        if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 97
            yield "          <li><a href=\"/dashboard\">Dashboard</a></li>
        ";
        }
        // line 99
        yield "      </ul>
    </div>

    <div class=\"footer-col\">
      <h4>Compte</h4>
      <ul>
        ";
        // line 105
        if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 106
            yield "          <li><a href=\"/profil\">Mon profil</a></li>
          <li><a href=\"/dashboard/wishlist\">Ma wish-list</a></li>
          <li><a href=\"/dashboard/candidatures\">Mes candidatures</a></li>
          <li><a href=\"/deconnexion\">Déconnexion</a></li>
        ";
        } else {
            // line 111
            yield "          <li><a href=\"/connexion\">Connexion</a></li>
        ";
        }
        // line 113
        yield "      </ul>
    </div>

    <div class=\"footer-col\">
      <h4>Informations</h4>
      <ul>
        <li><a href=\"/mentions-legales\">Mentions légales</a></li>
        <li><a href=\"/mentions-legales#donnees\">Confidentialité</a></li>
        <li><a href=\"/mentions-legales#cgu\">CGU</a></li>
      </ul>
    </div>

  </div>

  <div class=\"footer-bottom\">
    <span>© ";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield " StageHub — Projet CESI. Tous droits réservés.</span>
    <div class=\"footer-legal-links\">
      <a href=\"/mentions-legales\">Mentions légales</a>
      <a href=\"/mentions-legales#donnees\">Confidentialité</a>
      <a href=\"/mentions-legales#cgu\">CGU</a>
    </div>
  </div>
</footer>

";
        // line 142
        yield from $this->unwrap()->yieldBlock('extra_js', $context, $blocks);
        // line 143
        yield "
</body>
</html>
";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_meta_desc(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "StageHub — Plateforme de stages CESI";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "StageHub";
        yield from [];
    }

    // line 13
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_extra_css(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 15
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 76
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 142
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_extra_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
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
        return array (  323 => 142,  313 => 76,  303 => 15,  293 => 13,  282 => 7,  271 => 6,  263 => 143,  261 => 142,  249 => 128,  232 => 113,  228 => 111,  221 => 106,  219 => 105,  211 => 99,  207 => 97,  205 => 96,  189 => 82,  185 => 77,  183 => 76,  180 => 75,  171 => 65,  159 => 55,  156 => 54,  153 => 52,  149 => 50,  144 => 47,  140 => 45,  138 => 44,  135 => 43,  132 => 42,  126 => 39,  124 => 38,  122 => 37,  117 => 34,  110 => 32,  107 => 31,  105 => 30,  98 => 28,  91 => 26,  84 => 24,  78 => 20,  73 => 15,  70 => 14,  68 => 13,  59 => 7,  55 => 6,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"fr\">
<head>
  <meta charset=\"UTF-8\"/>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
  <meta name=\"description\" content=\"{% block meta_desc %}StageHub — Plateforme de stages CESI{% endblock %}\"/>
  <title>{% block title %}StageHub{% endblock %}</title>
  <link
    href=\"https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap\"
    rel=\"stylesheet\"
  />
  <link rel=\"stylesheet\" href=\"/assets/css/style.css\"/>
  {% block extra_css %}{% endblock %}
</head>
<body class=\"{% block body_class %}{% endblock %}\">

{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  NAVIGATION                                                                 #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<nav>
  <a href=\"/\" class=\"nav-logo\">Stage<span>Hub</span></a>

  <div class=\"nav-links\" id=\"navLinks\">
    <a href=\"/\"            {% if active == 'home'        %}class=\"active\"{% endif %}>Accueil</a>
    <span class=\"sep\" aria-hidden=\"true\">|</span>
    <a href=\"/offres\"      {% if active == 'offres'      %}class=\"active\"{% endif %}>Offres</a>
    <span class=\"sep\" aria-hidden=\"true\">|</span>
    <a href=\"/entreprises\" {% if active == 'entreprises' %}class=\"active\"{% endif %}>Entreprises</a>

    {% if app_user %}
      <span class=\"sep\" aria-hidden=\"true\">|</span>
      <a href=\"/dashboard\" {% if active == 'dashboard'   %}class=\"active\"{% endif %}>Dashboard</a>
    {% endif %}
  </div>

  <div class=\"nav-right\">
    {% if app_user %}
      {# Nom de l'utilisateur connecté #}
      <span class=\"nav-username\">{{ app_user.prenom }}</span>

      {# Badge de rôle — visible uniquement pour pilote et admin #}
      {% if app_user.role == 'administrator' %}
        <span class=\"nav-badge nav-badge--admin\">Admin</span>
      {% elseif app_user.role == 'pilote' %}
        <span class=\"nav-badge nav-badge--pilote\">Pilote</span>
      {% endif %}

      <a href=\"/deconnexion\" class=\"btn-login\">Déconnexion</a>
    {% else %}
      <a href=\"/connexion\" class=\"btn-login\">Connexion</a>
    {% endif %}

    {# Avatar / lien profil — uniquement si connecté #}
    {% if app_user %}
      <a href=\"/profil\" aria-label=\"Mon profil\">
        <div class=\"nav-avatar\">
          <svg viewBox=\"0 0 24 24\" fill=\"currentColor\" aria-hidden=\"true\">
            <path d=\"M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4
                     7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6
                     1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z\"/>
          </svg>
        </div>
      </a>
    {% endif %}

    <button class=\"nav-hamburger\" id=\"hamburger\" aria-label=\"Menu\" aria-expanded=\"false\">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  CONTENU PRINCIPAL                                                          #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<main id=\"main-content\">
  {% block content %}{% endblock %}
</main>

{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  FOOTER                                                                     #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<footer>
  <div class=\"footer-grid\">

    <div class=\"footer-brand\">
      <h3>Stage<span>Hub</span></h3>
      <p>La plateforme de mise en relation entre étudiants CESI et entreprises partenaires.</p>
    </div>

    <div class=\"footer-col\">
      <h4>Navigation</h4>
      <ul>
        <li><a href=\"/\">Accueil</a></li>
        <li><a href=\"/offres\">Offres de stage</a></li>
        <li><a href=\"/entreprises\">Entreprises</a></li>
        {% if app_user %}
          <li><a href=\"/dashboard\">Dashboard</a></li>
        {% endif %}
      </ul>
    </div>

    <div class=\"footer-col\">
      <h4>Compte</h4>
      <ul>
        {% if app_user %}
          <li><a href=\"/profil\">Mon profil</a></li>
          <li><a href=\"/dashboard/wishlist\">Ma wish-list</a></li>
          <li><a href=\"/dashboard/candidatures\">Mes candidatures</a></li>
          <li><a href=\"/deconnexion\">Déconnexion</a></li>
        {% else %}
          <li><a href=\"/connexion\">Connexion</a></li>
        {% endif %}
      </ul>
    </div>

    <div class=\"footer-col\">
      <h4>Informations</h4>
      <ul>
        <li><a href=\"/mentions-legales\">Mentions légales</a></li>
        <li><a href=\"/mentions-legales#donnees\">Confidentialité</a></li>
        <li><a href=\"/mentions-legales#cgu\">CGU</a></li>
      </ul>
    </div>

  </div>

  <div class=\"footer-bottom\">
    <span>© {{ \"now\"|date(\"Y\") }} StageHub — Projet CESI. Tous droits réservés.</span>
    <div class=\"footer-legal-links\">
      <a href=\"/mentions-legales\">Mentions légales</a>
      <a href=\"/mentions-legales#donnees\">Confidentialité</a>
      <a href=\"/mentions-legales#cgu\">CGU</a>
    </div>
  </div>
</footer>

{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  SCRIPTS                                                                    #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
{# index-script.js était chargé sur TOUTES les pages — déplacé dans extra_js  #}
{# de home/index.html.twig uniquement où il est réellement nécessaire          #}
{% block extra_js %}{% endblock %}

</body>
</html>
", "base.html.twig", "/var/www/stagehub.fr/templates/base.html.twig");
    }
}
