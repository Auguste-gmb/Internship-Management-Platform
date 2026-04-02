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

/* home/index.html.twig */
class __TwigTemplate_b00d08075f718d5ff325de00dae15cda extends Template
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
            'meta_desc' => [$this, 'block_meta_desc'],
            'body_class' => [$this, 'block_body_class'],
            'content' => [$this, 'block_content'],
            'extra_js' => [$this, 'block_extra_js'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 2
        $context["active"] = "home";
        // line 1
        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "StageHub — Trouvez votre stage idéal";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_meta_desc(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Trouvez votre stage idéal sur StageHub, la plateforme de stages CESI.";
        yield from [];
    }

    // line 6
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body_class(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "page-index";
        yield from [];
    }

    // line 8
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 9
        yield "
";
        // line 13
        yield "<div class=\"hero-wrapper\">
  <main class=\"hero\">

    <div class=\"hero-left\">
      <h1 class=\"hero-title\">
        Trouvez le <span class=\"accent\">stage</span><br>idéal pour vous !
      </h1>

      <form class=\"search-bar\" action=\"/offres\" method=\"GET\">
        <input
          class=\"search-input\"
          type=\"text\"
          name=\"q\"
          placeholder=\"Emploi, compétence…\"
          id=\"jobInput\"
          value=\"";
        // line 28
        yield (((array_key_exists("app_query", $context) &&  !(null === $context["app_query"]))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["app_query"], "html", null, true)) : (""));
        yield "\"
          autocomplete=\"off\"
        />
        <div class=\"search-divider\"></div>
        <input
          class=\"search-input\"
          type=\"text\"
          name=\"loc\"
          placeholder=\"Ville, région…\"
          id=\"locInput\"
          value=\"";
        // line 38
        yield (((array_key_exists("app_loc", $context) &&  !(null === $context["app_loc"]))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["app_loc"], "html", null, true)) : (""));
        yield "\"
          autocomplete=\"off\"
        />
        <button class=\"search-btn\" type=\"submit\" aria-label=\"Rechercher\">
          <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
               stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
               aria-hidden=\"true\">
            <circle cx=\"11\" cy=\"11\" r=\"8\"/>
            <line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/>
          </svg>
        </button>
      </form>

      <div class=\"popular\">
        <p class=\"popular-label\">Recherches populaires</p>
        <div class=\"tags\">
          ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(["Designer", "Développeur", "Web", "Marketing", "Data", "UX/UI"]);
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 55
            yield "            <a href=\"/offres?q=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::urlencode($context["tag"]), "html", null, true);
            yield "\" class=\"tag\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["tag"], "html", null, true);
            yield "</a>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tag'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
        yield "        </div>
      </div>
    </div>";
        // line 60
        yield "
    ";
        // line 62
        yield "    <div class=\"stats-card\" aria-label=\"Chiffres clés\">
      <div class=\"stat-item\">
        <span class=\"stat-number\" data-target=\"";
        // line 64
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", true, true, false, 64) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 64)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 64), "html", null, true)) : (0));
        yield "\">0</span>
        <span class=\"stat-label\">Offres disponibles</span>
      </div>
      <div class=\"stat-item\">
        <span class=\"stat-number\" data-target=\"";
        // line 68
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_entreprises", [], "any", true, true, false, 68) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_entreprises", [], "any", false, false, false, 68)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_entreprises", [], "any", false, false, false, 68), "html", null, true)) : (0));
        yield "\">0</span>
        <span class=\"stat-label\">Entreprises</span>
      </div>
      <div class=\"stat-item\">
        <span class=\"stat-number faded\" data-target=\"";
        // line 72
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_etudiants", [], "any", true, true, false, 72) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_etudiants", [], "any", false, false, false, 72)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_etudiants", [], "any", false, false, false, 72), "html", null, true)) : (0));
        yield "\">0</span>
        <span class=\"stat-label\">Étudiants inscrits</span>
      </div>
    </div>

  </main>

  <a class=\"scroll-arrow\" href=\"#offres\" aria-label=\"Découvrir les offres\">
    <span>Découvrir</span>
    <svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\"
         stroke=\"var(--salmon)\" stroke-width=\"2.5\"
         stroke-linecap=\"round\" stroke-linejoin=\"round\" aria-hidden=\"true\">
      <polyline points=\"6 9 12 15 18 9\"/>
    </svg>
  </a>
</div>";
        // line 88
        yield "

";
        // line 93
        yield "<section id=\"offres\" class=\"section\">
  <div class=\"section-header\">
    <h2 class=\"section-title\">Offres <span>récentes</span></h2>
    <a href=\"/offres\" class=\"see-all\">Voir toutes les offres →</a>
  </div>

  <div class=\"offers-grid-index\">
    ";
        // line 100
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["offres_recentes"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["offre"]) {
            // line 101
            yield "      <article class=\"offer-card-index\" data-offer-id=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 101), "html", null, true);
            yield "\">

        ";
            // line 104
            yield "        <div class=\"offer-company\">
          <div class=\"company-logo\" aria-hidden=\"true\">
            ";
            // line 106
            yield (((($tmp =  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise_name", [], "any", false, false, false, 106))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source,             // line 107
$context["offre"], "entreprise_name", [], "any", false, false, false, 107), 0, 2)), "html", null, true)) : ("??"));
            // line 108
            yield "
          </div>
          <span class=\"company-name\">
            ";
            // line 111
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise_name", [], "any", true, true, false, 111) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise_name", [], "any", false, false, false, 111)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise_name", [], "any", false, false, false, 111), "html", null, true)) : ("Entreprise inconnue"));
            yield "
          </span>
        </div>

        ";
            // line 116
            yield "        <a href=\"/offres/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 116), "html", null, true);
            yield "\" class=\"offer-title-link\">
          <p class=\"offer-title\">";
            // line 117
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "title", [], "any", false, false, false, 117), "html", null, true);
            yield "</p>
        </a>

        ";
            // line 121
            yield "        ";
            if ((($tmp =  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "skill", [], "any", false, false, false, 121))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 122
                yield "          <div class=\"offer-tags\" aria-label=\"Compétences\">
            ";
                // line 123
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "skill", [], "any", false, false, false, 123), ","));
                foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                    // line 124
                    yield "              <span class=\"offer-tag\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::trim($context["tag"]), "html", null, true);
                    yield "</span>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['tag'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 126
                yield "          </div>
        ";
            }
            // line 128
            yield "
        ";
            // line 130
            yield "        <div class=\"offer-footer\">
          <span class=\"offer-salary\">
            ";
            // line 132
            yield (((($tmp =  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "remuneration", [], "any", false, false, false, 132))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "remuneration", [], "any", false, false, false, 132), "html", null, true)) : ("Non précisé"));
            yield "
          </span>
          <span class=\"offer-location\">
            ";
            // line 135
            yield (((($tmp =  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "location", [], "any", false, false, false, 135))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "location", [], "any", false, false, false, 135), "html", null, true)) : (""));
            yield "
          </span>
          <time class=\"offer-date\" datetime=\"";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "publication_date", [], "any", false, false, false, 137), "html", null, true);
            yield "\">
            ";
            // line 138
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "publication_date", [], "any", true, true, false, 138) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "publication_date", [], "any", false, false, false, 138)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "publication_date", [], "any", false, false, false, 138), "html", null, true)) : (""));
            yield "
          </time>

          ";
            // line 142
            yield "          ";
            if ((($tmp = App\Core\Auth::can("wishlist.manage")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 143
                yield "            <button
              class=\"wishlist-btn\"
              data-offer-id=\"";
                // line 145
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 145), "html", null, true);
                yield "\"
              aria-label=\"Ajouter aux favoris\"
              aria-pressed=\"false\"
            >
              <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
                   stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
                   aria-hidden=\"true\">
                <path d=\"M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67
                         l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78
                         l1.06 1.06L12 21.23l7.78-7.78
                         1.06-1.06a5.5 5.5 0 0 0 0-7.78z\"/>
              </svg>
            </button>
          ";
            }
            // line 159
            yield "        </div>

      </article>
    ";
            $context['_iterated'] = true;
        }
        // line 162
        if (!$context['_iterated']) {
            // line 163
            yield "      <p class=\"empty-state\">
        Aucune offre disponible pour le moment.
      </p>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['offre'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 167
        yield "  </div>
</section>


";
        // line 174
        yield "<section class=\"companies-section\" id=\"entreprises\">
  <div class=\"companies-inner\">
    <div class=\"section-header\">
      <h2 class=\"section-title\">Entreprises <span>partenaires</span></h2>
      <a href=\"/entreprises\" class=\"see-all\">Voir toutes →</a>
    </div>

    <div class=\"companies-grid\">
      ";
        // line 182
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["entreprises_vedette"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["entreprise"]) {
            // line 183
            yield "        <a href=\"/entreprises/";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "id_entreprise", [], "any", false, false, false, 183), "html", null, true);
            yield "\" class=\"company-card-index\">
          <div class=\"logo-big\" aria-hidden=\"true\">
            ";
            // line 185
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "name", [], "any", false, false, false, 185), 0, 2)), "html", null, true);
            yield "
          </div>
          <h3>";
            // line 187
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "name", [], "any", false, false, false, 187), "html", null, true);
            yield "</h3>
          <p>
            ";
            // line 189
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "nb_offres", [], "any", true, true, false, 189) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "nb_offres", [], "any", false, false, false, 189)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "nb_offres", [], "any", false, false, false, 189), "html", null, true)) : (0));
            yield "
            ";
            // line 190
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "nb_offres", [], "any", false, false, false, 190) == 1)) ? ("offre active") : ("offres actives"));
            yield "
          </p>
          <div class=\"stars\" aria-label=\"Note : ";
            // line 192
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", true, true, false, 192) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 192)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 192), "html", null, true)) : (0));
            yield "/5\">";
            // line 193
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(1, 5));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 194
                yield "<span class=\"";
                yield ((((((CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", true, true, false, 194) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 194)))) ? (CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 194)) : (0)) >= $context["i"])) ? ("star--full") : ("star--empty"));
                yield "\"
                    aria-hidden=\"true\">";
                // line 196
                yield ((((((CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", true, true, false, 196) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 196)))) ? (CoreExtension::getAttribute($this->env, $this->source, $context["entreprise"], "note_moyenne", [], "any", false, false, false, 196)) : (0)) >= $context["i"])) ? ("★") : ("☆"));
                // line 197
                yield "</span>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 199
            yield "</div>
        </a>
      ";
            $context['_iterated'] = true;
        }
        // line 201
        if (!$context['_iterated']) {
            // line 202
            yield "        <p class=\"empty-state\">Aucune entreprise partenaire pour le moment.</p>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['entreprise'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 204
        yield "    </div>
  </div>
</section>


";
        // line 213
        if ((($tmp =  !($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 214
            yield "  <section class=\"cta-section\">
    <h2>Prêt à trouver votre <span>stage</span> ?</h2>
    <p>Inscrivez-vous gratuitement et accédez à toutes les offres en quelques clics.</p>
    <div class=\"cta-btns\">
      <a href=\"/connexion\" class=\"btn-primary\">Créer un compte étudiant</a>
      <a href=\"/connexion\" class=\"btn-secondary\">Se connecter</a>
    </div>
  </section>
";
        }
        // line 223
        yield "
";
        yield from [];
    }

    // line 230
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_extra_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 231
        yield "  <script src=\"/assets/js/index-script.js\"></script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home/index.html.twig";
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
        return array (  469 => 231,  462 => 230,  456 => 223,  445 => 214,  443 => 213,  436 => 204,  429 => 202,  427 => 201,  421 => 199,  415 => 197,  413 => 196,  408 => 194,  404 => 193,  401 => 192,  396 => 190,  392 => 189,  387 => 187,  382 => 185,  376 => 183,  371 => 182,  361 => 174,  355 => 167,  346 => 163,  344 => 162,  337 => 159,  320 => 145,  316 => 143,  313 => 142,  307 => 138,  303 => 137,  298 => 135,  292 => 132,  288 => 130,  285 => 128,  281 => 126,  272 => 124,  268 => 123,  265 => 122,  262 => 121,  256 => 117,  251 => 116,  244 => 111,  239 => 108,  237 => 107,  236 => 106,  232 => 104,  226 => 101,  221 => 100,  212 => 93,  208 => 88,  190 => 72,  183 => 68,  176 => 64,  172 => 62,  169 => 60,  165 => 57,  154 => 55,  150 => 54,  131 => 38,  118 => 28,  101 => 13,  98 => 9,  91 => 8,  80 => 6,  69 => 5,  58 => 4,  53 => 1,  51 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}
{% set active = 'home' %}

{% block title %}StageHub — Trouvez votre stage idéal{% endblock %}
{% block meta_desc %}Trouvez votre stage idéal sur StageHub, la plateforme de stages CESI.{% endblock %}
{% block body_class %}page-index{% endblock %}

{% block content %}

{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  HERO                                                                       #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<div class=\"hero-wrapper\">
  <main class=\"hero\">

    <div class=\"hero-left\">
      <h1 class=\"hero-title\">
        Trouvez le <span class=\"accent\">stage</span><br>idéal pour vous !
      </h1>

      <form class=\"search-bar\" action=\"/offres\" method=\"GET\">
        <input
          class=\"search-input\"
          type=\"text\"
          name=\"q\"
          placeholder=\"Emploi, compétence…\"
          id=\"jobInput\"
          value=\"{{ app_query ?? '' }}\"
          autocomplete=\"off\"
        />
        <div class=\"search-divider\"></div>
        <input
          class=\"search-input\"
          type=\"text\"
          name=\"loc\"
          placeholder=\"Ville, région…\"
          id=\"locInput\"
          value=\"{{ app_loc ?? '' }}\"
          autocomplete=\"off\"
        />
        <button class=\"search-btn\" type=\"submit\" aria-label=\"Rechercher\">
          <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
               stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
               aria-hidden=\"true\">
            <circle cx=\"11\" cy=\"11\" r=\"8\"/>
            <line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/>
          </svg>
        </button>
      </form>

      <div class=\"popular\">
        <p class=\"popular-label\">Recherches populaires</p>
        <div class=\"tags\">
          {% for tag in ['Designer', 'Développeur', 'Web', 'Marketing', 'Data', 'UX/UI'] %}
            <a href=\"/offres?q={{ tag|url_encode }}\" class=\"tag\">{{ tag }}</a>
          {% endfor %}
        </div>
      </div>
    </div>{# /.hero-left #}

    {# ── Compteurs animés ── #}
    <div class=\"stats-card\" aria-label=\"Chiffres clés\">
      <div class=\"stat-item\">
        <span class=\"stat-number\" data-target=\"{{ stats.total_offres ?? 0 }}\">0</span>
        <span class=\"stat-label\">Offres disponibles</span>
      </div>
      <div class=\"stat-item\">
        <span class=\"stat-number\" data-target=\"{{ stats.total_entreprises ?? 0 }}\">0</span>
        <span class=\"stat-label\">Entreprises</span>
      </div>
      <div class=\"stat-item\">
        <span class=\"stat-number faded\" data-target=\"{{ stats.total_etudiants ?? 0 }}\">0</span>
        <span class=\"stat-label\">Étudiants inscrits</span>
      </div>
    </div>

  </main>

  <a class=\"scroll-arrow\" href=\"#offres\" aria-label=\"Découvrir les offres\">
    <span>Découvrir</span>
    <svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\"
         stroke=\"var(--salmon)\" stroke-width=\"2.5\"
         stroke-linecap=\"round\" stroke-linejoin=\"round\" aria-hidden=\"true\">
      <polyline points=\"6 9 12 15 18 9\"/>
    </svg>
  </a>
</div>{# /.hero-wrapper #}


{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  OFFRES RÉCENTES                                                            #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<section id=\"offres\" class=\"section\">
  <div class=\"section-header\">
    <h2 class=\"section-title\">Offres <span>récentes</span></h2>
    <a href=\"/offres\" class=\"see-all\">Voir toutes les offres →</a>
  </div>

  <div class=\"offers-grid-index\">
    {% for offre in offres_recentes %}
      <article class=\"offer-card-index\" data-offer-id=\"{{ offre.id_offer }}\">

        {# En-tête entreprise #}
        <div class=\"offer-company\">
          <div class=\"company-logo\" aria-hidden=\"true\">
            {{ offre.entreprise_name is not empty
                ? offre.entreprise_name|slice(0,2)|upper
                : '??' }}
          </div>
          <span class=\"company-name\">
            {{ offre.entreprise_name ?? 'Entreprise inconnue' }}
          </span>
        </div>

        {# Titre #}
        <a href=\"/offres/{{ offre.id_offer }}\" class=\"offer-title-link\">
          <p class=\"offer-title\">{{ offre.title }}</p>
        </a>

        {# Compétences #}
        {% if offre.skill is not empty %}
          <div class=\"offer-tags\" aria-label=\"Compétences\">
            {% for tag in offre.skill|split(',') %}
              <span class=\"offer-tag\">{{ tag|trim }}</span>
            {% endfor %}
          </div>
        {% endif %}

        {# Pied de carte #}
        <div class=\"offer-footer\">
          <span class=\"offer-salary\">
            {{ offre.remuneration is not empty ? offre.remuneration : 'Non précisé' }}
          </span>
          <span class=\"offer-location\">
            {{ offre.location is not empty ? offre.location : '' }}
          </span>
          <time class=\"offer-date\" datetime=\"{{ offre.publication_date }}\">
            {{ offre.publication_date ?? '' }}
          </time>

          {# Bouton wishlist — uniquement si connecté avec la permission #}
          {% if auth_can('wishlist.manage') %}
            <button
              class=\"wishlist-btn\"
              data-offer-id=\"{{ offre.id_offer }}\"
              aria-label=\"Ajouter aux favoris\"
              aria-pressed=\"false\"
            >
              <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
                   stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"
                   aria-hidden=\"true\">
                <path d=\"M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67
                         l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78
                         l1.06 1.06L12 21.23l7.78-7.78
                         1.06-1.06a5.5 5.5 0 0 0 0-7.78z\"/>
              </svg>
            </button>
          {% endif %}
        </div>

      </article>
    {% else %}
      <p class=\"empty-state\">
        Aucune offre disponible pour le moment.
      </p>
    {% endfor %}
  </div>
</section>


{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  ENTREPRISES PARTENAIRES                                                    #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
<section class=\"companies-section\" id=\"entreprises\">
  <div class=\"companies-inner\">
    <div class=\"section-header\">
      <h2 class=\"section-title\">Entreprises <span>partenaires</span></h2>
      <a href=\"/entreprises\" class=\"see-all\">Voir toutes →</a>
    </div>

    <div class=\"companies-grid\">
      {% for entreprise in entreprises_vedette %}
        <a href=\"/entreprises/{{ entreprise.id_entreprise }}\" class=\"company-card-index\">
          <div class=\"logo-big\" aria-hidden=\"true\">
            {{ entreprise.name|slice(0,2)|upper }}
          </div>
          <h3>{{ entreprise.name }}</h3>
          <p>
            {{ entreprise.nb_offres ?? 0 }}
            {{ entreprise.nb_offres == 1 ? 'offre active' : 'offres actives' }}
          </p>
          <div class=\"stars\" aria-label=\"Note : {{ entreprise.note_moyenne ?? 0 }}/5\">
            {%- for i in 1..5 -%}
              <span class=\"{{ (entreprise.note_moyenne ?? 0) >= i ? 'star--full' : 'star--empty' }}\"
                    aria-hidden=\"true\">
                {{- (entreprise.note_moyenne ?? 0) >= i ? '★' : '☆' -}}
              </span>
            {%- endfor -%}
          </div>
        </a>
      {% else %}
        <p class=\"empty-state\">Aucune entreprise partenaire pour le moment.</p>
      {% endfor %}
    </div>
  </div>
</section>


{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  CALL TO ACTION                                                             #}
{#  Affiché uniquement si l'utilisateur n'est pas connecté                    #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
{% if not app_user %}
  <section class=\"cta-section\">
    <h2>Prêt à trouver votre <span>stage</span> ?</h2>
    <p>Inscrivez-vous gratuitement et accédez à toutes les offres en quelques clics.</p>
    <div class=\"cta-btns\">
      <a href=\"/connexion\" class=\"btn-primary\">Créer un compte étudiant</a>
      <a href=\"/connexion\" class=\"btn-secondary\">Se connecter</a>
    </div>
  </section>
{% endif %}

{% endblock %}


{# ═══════════════════════════════════════════════════════════════════════════ #}
{#  SCRIPTS                                                                    #}
{# ═══════════════════════════════════════════════════════════════════════════ #}
{% block extra_js %}
  <script src=\"/assets/js/index-script.js\"></script>
{% endblock %}
", "home/index.html.twig", "/var/www/stagehub.fr/templates/home/index.html.twig");
    }
}
