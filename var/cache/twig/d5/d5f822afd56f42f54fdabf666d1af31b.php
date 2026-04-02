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

/* offre/list.html.twig */
class __TwigTemplate_f7b1e29779be1b9b1957782e59ca87c3 extends Template
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
        $context["active"] = "offres";
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
        yield "StageHub — Offres de stage";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_meta_desc(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Parcourez toutes les offres de stage disponibles sur StageHub.";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "
";
        // line 10
        yield "<div class=\"page-header\">
  <div class=\"page-header-inner\">

    <div class=\"breadcrumb\">
      <a href=\"/\">Accueil</a>
      <span>›</span>
      <span class=\"current\">Offres</span>
    </div>

    <h1>Toutes les <em>offres</em> de stage</h1>
    <p>";
        // line 20
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", true, true, false, 20) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 20)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 20), "html", null, true)) : (0));
        yield " offre";
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 20) > 1)) ? ("s") : (""));
        yield " disponible";
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 20) > 1)) ? ("s") : (""));
        yield "</p>

    <div class=\"search-wrap\">
      <form class=\"search-bar\" action=\"/offres\" method=\"GET\">
        <input class=\"search-input\" type=\"text\" name=\"q\"
               placeholder=\"Emploi, compétence...\" id=\"jobInput\"
               value=\"";
        // line 26
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", true, true, false, 26) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", false, false, false, 26)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", false, false, false, 26), "html", null, true)) : (""));
        yield "\"/>
        <div class=\"search-divider\"></div>
        <input class=\"search-input\" type=\"text\" name=\"loc\"
               placeholder=\"Ville, région…\" id=\"locInput\"
               style=\"max-width: 200px\"
               value=\"";
        // line 31
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", true, true, false, 31) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 31)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 31), "html", null, true)) : (""));
        yield "\"/>
        <button class=\"search-btn\" type=\"submit\" aria-label=\"Rechercher\">
          <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
               stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
            <circle cx=\"11\" cy=\"11\" r=\"8\"/>
            <line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/>
          </svg>
        </button>
      </form>
    </div>

  </div>
</div>

";
        // line 46
        yield "
<div class=\"layout\">

  <button class=\"filter-toggle-btn\" id=\"filterToggle\">
    <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
         stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
      <line x1=\"4\"  y1=\"6\"  x2=\"20\" y2=\"6\"/>
      <line x1=\"8\"  y1=\"12\" x2=\"16\" y2=\"12\"/>
      <line x1=\"10\" y1=\"18\" x2=\"14\" y2=\"18\"/>
    </svg>
    Filtres
  </button>

  <aside class=\"sidebar\" id=\"sidebar\">
    <form id=\"filterForm\" action=\"/offres\" method=\"GET\">

      ";
        // line 63
        yield "      <input type=\"hidden\" name=\"q\"   value=\"";
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", true, true, false, 63) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", false, false, false, 63)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "q", [], "any", false, false, false, 63), "html", null, true)) : (""));
        yield "\"/>
      <input type=\"hidden\" name=\"loc\" value=\"";
        // line 64
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", true, true, false, 64) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 64)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 64), "html", null, true)) : (""));
        yield "\"/>

      ";
        // line 67
        yield "      <div class=\"filter-card\">
        <h3>Domaine</h3>
        <div class=\"filter-options\" id=\"domain\">
          ";
        // line 70
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["domaines"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
            // line 71
            yield "            <label class=\"filter-option\">
              <input type=\"checkbox\" name=\"domain[]\" value=\"";
            // line 72
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "id_domain", [], "any", false, false, false, 72), "html", null, true);
            yield "\"
                     ";
            // line 73
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "domain", [], "any", true, true, false, 73) && CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "id_domain", [], "any", false, false, false, 73), CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "domain", [], "any", false, false, false, 73)))) {
                yield "checked";
            }
            // line 74
            yield "                     onchange=\"this.form.submit()\"/>
              <span class=\"custom-check\">
                <svg viewBox=\"0 0 12 12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\">
                  <polyline points=\"1.5,6 5,9.5 10.5,2.5\"/>
                </svg>
              </span>
              <span class=\"filter-label\">
                ";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "name", [], "any", false, false, false, 81), "html", null, true);
            yield " <span class=\"filter-count\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "count", [], "any", false, false, false, 81), "html", null, true);
            yield "</span>
              </span>
            </label>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 85
        yield "        </div>
      </div>

      ";
        // line 89
        yield "      <div class=\"filter-card\">
        <h3>Durée</h3>
        <div class=\"filter-options\" id=\"duration\">
          ";
        // line 92
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(["3 mois", "6 mois", "12 mois"]);
        foreach ($context['_seq'] as $context["_key"] => $context["dur"]) {
            // line 93
            yield "            <label class=\"filter-option\">
              <input type=\"checkbox\" name=\"duration\" value=\"";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["dur"], "html", null, true);
            yield "\"
                     ";
            // line 95
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "duration", [], "any", true, true, false, 95) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "duration", [], "any", false, false, false, 95) == $context["dur"]))) {
                yield "checked";
            }
            // line 96
            yield "                     onchange=\"this.form.submit()\"/>
              <span class=\"custom-check\">
                <svg viewBox=\"0 0 12 12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\">
                  <polyline points=\"1.5,6 5,9.5 10.5,2.5\"/>
                </svg>
              </span>
              <span class=\"filter-label\">";
            // line 102
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["dur"], "html", null, true);
            yield "</span>
            </label>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['dur'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 105
        yield "        </div>
      </div>

      ";
        // line 109
        yield "      <div class=\"filter-card\">
        <h3>Rémunération</h3>
        <div class=\"range-wrap\">
          <div class=\"range-display\">
            <span>0 €</span>
            <span id=\"rangeVal\">
              ";
        // line 115
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", true, true, false, 115) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 115) > 0))) {
            // line 116
            yield "                ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 116), "html", null, true);
            yield " €/mois
              ";
        } else {
            // line 118
            yield "                4 000 €/mois
              ";
        }
        // line 120
        yield "            </span>
          </div>
          <input type=\"range\" min=\"0\" max=\"4000\"
                 value=\"";
        // line 123
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", true, true, false, 123) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 123)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 123), "html", null, true)) : (4000));
        yield "\"
                 id=\"salaryRange\" name=\"remu_max\"
                 oninput=\"updateRange(this.value); this.form.submit()\"/>
        </div>
      </div>

      <button type=\"submit\" class=\"apply-btn\">Appliquer</button>
      <a href=\"/offres\" class=\"apply-btn\"
         style=\"display:block;text-align:center;margin-top:8px;background:#eee;color:#333\">
        Réinitialiser
      </a>
    </form>
  </aside>


  ";
        // line 139
        yield "  <div class=\"main-content\">

    <div class=\"results-bar\">
      <p class=\"results-count\">
        <strong>";
        // line 143
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", true, true, false, 143) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 143)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 143), "html", null, true)) : (0));
        yield " offre";
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 143) > 1)) ? ("s") : (""));
        yield "</strong> 
        ";
        // line 144
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["stats"] ?? null), "total_offres", [], "any", false, false, false, 144) > 1)) ? ("correspondent") : ("correspond"));
        yield " à votre recherche
      </p>
      <div class=\"sort-wrap\">
        <span class=\"sort-label\">Trier par</span>
        <select class=\"sort-select\">
          <option>Plus récentes</option>
          <option>Rémunération ↑</option>
          <option>Rémunération ↓</option>
          <option>Entreprise A–Z</option>
        </select>
      </div>
    </div>

    ";
        // line 158
        yield "    <div class=\"active-filters\" id=\"activeFilters\">

      ";
        // line 161
        yield "      ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "duration", [], "any", true, true, false, 161) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "duration", [], "any", false, false, false, 161) != ""))) {
            // line 162
            yield "        <button class=\"chip\" onclick=\"removeChip(this, 'duration')\">
          ";
            // line 163
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "duration", [], "any", false, false, false, 163), "html", null, true);
            yield " <span class=\"chip-x\">×</span>
        </button>
      ";
        }
        // line 166
        yield "
      ";
        // line 168
        yield "      ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "domain", [], "any", true, true, false, 168) && is_iterable(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "domain", [], "any", false, false, false, 168)))) {
            // line 169
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "domain", [], "any", false, false, false, 169));
            foreach ($context['_seq'] as $context["_key"] => $context["domainId"]) {
                // line 170
                yield "          ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["domaines"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["d"]) {
                    // line 171
                    yield "            ";
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["d"], "id_domain", [], "any", false, false, false, 171) == $context["domainId"])) {
                        // line 172
                        yield "              <button class=\"chip\" onclick=\"removeChip(this, 'domain', ";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "id_domain", [], "any", false, false, false, 172), "html", null, true);
                        yield ")\">
                ";
                        // line 173
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["d"], "name", [], "any", false, false, false, 173), "html", null, true);
                        yield " <span class=\"chip-x\">×</span>
              </button>
            ";
                    }
                    // line 176
                    yield "          ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['d'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 177
                yield "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['domainId'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 178
            yield "      ";
        }
        // line 179
        yield "
      ";
        // line 181
        yield "      ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", true, true, false, 181) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 181) != ""))) {
            // line 182
            yield "        <button class=\"chip\" onclick=\"removeChip(this, 'loc')\">
          ";
            // line 183
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "loc", [], "any", false, false, false, 183), "html", null, true);
            yield " <span class=\"chip-x\">×</span>
        </button>
      ";
        }
        // line 186
        yield "
      ";
        // line 188
        yield "      ";
        if (((CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", true, true, false, 188) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 188) > 0)) && (CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 188) < 4000))) {
            // line 189
            yield "        <button class=\"chip\" onclick=\"removeChip(this, 'remu_max')\">
          Jusqu'à ";
            // line 190
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["filters"] ?? null), "remu_max", [], "any", false, false, false, 190), "html", null, true);
            yield " €/mois <span class=\"chip-x\">×</span>
        </button>
      ";
        }
        // line 193
        yield "
    </div>

    ";
        // line 197
        yield "    <div class=\"offers-grid\">
      ";
        // line 198
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["offres"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["offre"]) {
            // line 199
            yield "        <article class=\"offer-card\" data-domain=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "domain", [], "any", false, false, false, 199)), "html", null, true);
            yield "\">
          <span class=\"domain-badge\">";
            // line 200
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "domain", [], "any", true, true, false, 200) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "domain", [], "any", false, false, false, 200)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "domain", [], "any", false, false, false, 200), "html", null, true)) : ("—"));
            yield "</span>

          <div class=\"offer-top\">
            <div class=\"offer-company\">
              <div class=\"company-logo\">";
            // line 204
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise", [], "any", false, false, false, 204), 0, 2)), "html", null, true);
            yield "</div>
              <span class=\"company-name\">";
            // line 205
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "entreprise", [], "any", false, false, false, 205), "html", null, true);
            yield "</span>
            </div>
          </div>

          <p class=\"offer-title\">";
            // line 209
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "title", [], "any", false, false, false, 209), "html", null, true);
            yield "</p>

          <div class=\"offer-location\">
            <svg viewBox=\"0 0 24 24\" fill=\"currentColor\">
              <path d=\"M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z\"/>
            </svg>
            ";
            // line 215
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "location", [], "any", false, false, false, 215), "html", null, true);
            yield "
          </div>

          <div class=\"offer-tags\">
            ";
            // line 219
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "skill", [], "any", false, false, false, 219)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 220
                yield "              ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::split($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "skill", [], "any", false, false, false, 220), ","));
                foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                    // line 221
                    yield "                <span class=\"offer-tag\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::trim($context["tag"]), "html", null, true);
                    yield "</span>
              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['tag'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 223
                yield "            ";
            }
            // line 224
            yield "          </div>

          <div class=\"offer-footer\">
            <span class=\"offer-salary\">";
            // line 227
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "remuneration", [], "any", true, true, false, 227) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "remuneration", [], "any", false, false, false, 227)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "remuneration", [], "any", false, false, false, 227), "html", null, true)) : ("N/A"));
            yield "</span>
            <span class=\"offer-date\">";
            // line 228
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "publication_date", [], "any", false, false, false, 228), "d/m/Y"), "html", null, true);
            yield "</span>
            <a href=\"/offres/";
            // line 229
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 229), "html", null, true);
            yield "\" class=\"btn-voir\">Voir</a>
            
            ";
            // line 232
            yield "            ";
            if ((($tmp = ($context["app_user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 233
                yield "              <button class=\"wishlist-btn ";
                if ((($tmp = ((CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "in_wishlist", [], "any", true, true, false, 233)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "in_wishlist", [], "any", false, false, false, 233), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "active";
                }
                yield "\" 
                      onclick=\"toggleWish(this, ";
                // line 234
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 234), "html", null, true);
                yield ")\" 
                      aria-label=\"Ajouter aux favoris\"
                      data-offer-id=\"";
                // line 236
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["offre"], "id_offer", [], "any", false, false, false, 236), "html", null, true);
                yield "\">
                <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
                     stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
                  <path d=\"M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z\"/>
                </svg>
              </button>
            ";
            }
            // line 243
            yield "          </div>

        </article>
      ";
            $context['_iterated'] = true;
        }
        // line 246
        if (!$context['_iterated']) {
            // line 247
            yield "        <p style=\"color:#999; grid-column:1/-1; text-align:center; padding:60px 0\">
          Aucune offre ne correspond à votre recherche.
        </p>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['offre'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 251
        yield "    </div>

    ";
        // line 254
        yield "    ";
        if ((array_key_exists("pagination", $context) && (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 254) > 1))) {
            // line 255
            yield "
      <div class=\"pagination\">

        ";
            // line 259
            yield "        ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 259) > 1)) {
                // line 260
                yield "          <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('path')->getCallable()("offres", Twig\Extension\CoreExtension::merge(($context["filters"] ?? null), ["page" => (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 260) - 1)])), "html", null, true);
                yield "\"
            class=\"page-btn arrow\">‹</a>
        ";
            }
            // line 263
            yield "
        ";
            // line 265
            yield "        ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(1, CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 265)));
            foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
                // line 266
                yield "          ";
                if (($context["p"] == CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 266))) {
                    // line 267
                    yield "            <button class=\"page-btn active\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["p"], "html", null, true);
                    yield "</button>
          ";
                } elseif ((((                // line 268
$context["p"] <= 3) || ($context["p"] > (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 268) - 2))) || (($context["p"] >= (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 268) - 1)) && ($context["p"] <= (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 268) + 1))))) {
                    // line 269
                    yield "            <a href=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('path')->getCallable()("offres", Twig\Extension\CoreExtension::merge(($context["filters"] ?? null), ["page" => $context["p"]])), "html", null, true);
                    yield "\"
              class=\"page-btn\">";
                    // line 270
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["p"], "html", null, true);
                    yield "</a>
          ";
                } elseif (((                // line 271
$context["p"] == 4) || ($context["p"] == (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 271) - 2)))) {
                    // line 272
                    yield "            <span style=\"font-weight:700;color:#ccc;padding:0 4px\">…</span>
          ";
                }
                // line 274
                yield "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['p'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 275
            yield "
        ";
            // line 277
            yield "        ";
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 277) < CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "total_pages", [], "any", false, false, false, 277))) {
                // line 278
                yield "          <a href=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('path')->getCallable()("offres", Twig\Extension\CoreExtension::merge(($context["filters"] ?? null), ["page" => (CoreExtension::getAttribute($this->env, $this->source, ($context["pagination"] ?? null), "current", [], "any", false, false, false, 278) + 1)])), "html", null, true);
                yield "\"
            class=\"page-btn arrow\">›</a>
        ";
            }
            // line 281
            yield "
      </div>
    ";
        }
        // line 284
        yield "
  </div>";
        // line 286
        yield "
</div>";
        // line 288
        yield "
";
        yield from [];
    }

    // line 291
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_extra_js(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 292
        yield "<script src=\"/assets/js/offer-script.js\"></script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "offre/list.html.twig";
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
        return array (  647 => 292,  640 => 291,  634 => 288,  631 => 286,  628 => 284,  623 => 281,  616 => 278,  613 => 277,  610 => 275,  604 => 274,  600 => 272,  598 => 271,  594 => 270,  589 => 269,  587 => 268,  582 => 267,  579 => 266,  574 => 265,  571 => 263,  564 => 260,  561 => 259,  556 => 255,  553 => 254,  549 => 251,  540 => 247,  538 => 246,  531 => 243,  521 => 236,  516 => 234,  509 => 233,  506 => 232,  501 => 229,  497 => 228,  493 => 227,  488 => 224,  485 => 223,  476 => 221,  471 => 220,  469 => 219,  462 => 215,  453 => 209,  446 => 205,  442 => 204,  435 => 200,  430 => 199,  425 => 198,  422 => 197,  417 => 193,  411 => 190,  408 => 189,  405 => 188,  402 => 186,  396 => 183,  393 => 182,  390 => 181,  387 => 179,  384 => 178,  378 => 177,  372 => 176,  366 => 173,  361 => 172,  358 => 171,  353 => 170,  348 => 169,  345 => 168,  342 => 166,  336 => 163,  333 => 162,  330 => 161,  326 => 158,  310 => 144,  304 => 143,  298 => 139,  280 => 123,  275 => 120,  271 => 118,  265 => 116,  263 => 115,  255 => 109,  250 => 105,  241 => 102,  233 => 96,  229 => 95,  225 => 94,  222 => 93,  218 => 92,  213 => 89,  208 => 85,  196 => 81,  187 => 74,  183 => 73,  179 => 72,  176 => 71,  172 => 70,  167 => 67,  162 => 64,  157 => 63,  139 => 46,  122 => 31,  114 => 26,  101 => 20,  89 => 10,  86 => 8,  79 => 7,  68 => 5,  57 => 4,  52 => 1,  50 => 2,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}
{% set active = 'offres' %}

{% block title %}StageHub — Offres de stage{% endblock %}
{% block meta_desc %}Parcourez toutes les offres de stage disponibles sur StageHub.{% endblock %}

{% block content %}

{# ════ PAGE HEADER ══════════════════════════════════════════════════════════ #}
<div class=\"page-header\">
  <div class=\"page-header-inner\">

    <div class=\"breadcrumb\">
      <a href=\"/\">Accueil</a>
      <span>›</span>
      <span class=\"current\">Offres</span>
    </div>

    <h1>Toutes les <em>offres</em> de stage</h1>
    <p>{{ stats.total_offres ?? 0 }} offre{{ stats.total_offres > 1 ? 's' : '' }} disponible{{ stats.total_offres > 1 ? 's' : '' }}</p>

    <div class=\"search-wrap\">
      <form class=\"search-bar\" action=\"/offres\" method=\"GET\">
        <input class=\"search-input\" type=\"text\" name=\"q\"
               placeholder=\"Emploi, compétence...\" id=\"jobInput\"
               value=\"{{ filters.q ?? '' }}\"/>
        <div class=\"search-divider\"></div>
        <input class=\"search-input\" type=\"text\" name=\"loc\"
               placeholder=\"Ville, région…\" id=\"locInput\"
               style=\"max-width: 200px\"
               value=\"{{ filters.loc ?? '' }}\"/>
        <button class=\"search-btn\" type=\"submit\" aria-label=\"Rechercher\">
          <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
               stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
            <circle cx=\"11\" cy=\"11\" r=\"8\"/>
            <line x1=\"21\" y1=\"21\" x2=\"16.65\" y2=\"16.65\"/>
          </svg>
        </button>
      </form>
    </div>

  </div>
</div>

{# ════ LAYOUT ═══════════════════════════════════════════════════════════════ #}

<div class=\"layout\">

  <button class=\"filter-toggle-btn\" id=\"filterToggle\">
    <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
         stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
      <line x1=\"4\"  y1=\"6\"  x2=\"20\" y2=\"6\"/>
      <line x1=\"8\"  y1=\"12\" x2=\"16\" y2=\"12\"/>
      <line x1=\"10\" y1=\"18\" x2=\"14\" y2=\"18\"/>
    </svg>
    Filtres
  </button>

  <aside class=\"sidebar\" id=\"sidebar\">
    <form id=\"filterForm\" action=\"/offres\" method=\"GET\">

      {# Conserver les paramètres de recherche #}
      <input type=\"hidden\" name=\"q\"   value=\"{{ filters.q ?? '' }}\"/>
      <input type=\"hidden\" name=\"loc\" value=\"{{ filters.loc ?? '' }}\"/>

      {# Domaine #}
      <div class=\"filter-card\">
        <h3>Domaine</h3>
        <div class=\"filter-options\" id=\"domain\">
          {% for d in domaines %}
            <label class=\"filter-option\">
              <input type=\"checkbox\" name=\"domain[]\" value=\"{{ d.id_domain }}\"
                     {% if filters.domain is defined and d.id_domain in filters.domain %}checked{% endif %}
                     onchange=\"this.form.submit()\"/>
              <span class=\"custom-check\">
                <svg viewBox=\"0 0 12 12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\">
                  <polyline points=\"1.5,6 5,9.5 10.5,2.5\"/>
                </svg>
              </span>
              <span class=\"filter-label\">
                {{ d.name }} <span class=\"filter-count\">{{ d.count }}</span>
              </span>
            </label>
          {% endfor %}
        </div>
      </div>

      {# Durée #}
      <div class=\"filter-card\">
        <h3>Durée</h3>
        <div class=\"filter-options\" id=\"duration\">
          {% for dur in ['3 mois', '6 mois', '12 mois'] %}
            <label class=\"filter-option\">
              <input type=\"checkbox\" name=\"duration\" value=\"{{ dur }}\"
                     {% if filters.duration is defined and filters.duration == dur %}checked{% endif %}
                     onchange=\"this.form.submit()\"/>
              <span class=\"custom-check\">
                <svg viewBox=\"0 0 12 12\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\">
                  <polyline points=\"1.5,6 5,9.5 10.5,2.5\"/>
                </svg>
              </span>
              <span class=\"filter-label\">{{ dur }}</span>
            </label>
          {% endfor %}
        </div>
      </div>

      {# Rémunération #}
      <div class=\"filter-card\">
        <h3>Rémunération</h3>
        <div class=\"range-wrap\">
          <div class=\"range-display\">
            <span>0 €</span>
            <span id=\"rangeVal\">
              {% if filters.remu_max is defined and filters.remu_max > 0 %}
                {{ filters.remu_max }} €/mois
              {% else %}
                4 000 €/mois
              {% endif %}
            </span>
          </div>
          <input type=\"range\" min=\"0\" max=\"4000\"
                 value=\"{{ filters.remu_max ?? 4000 }}\"
                 id=\"salaryRange\" name=\"remu_max\"
                 oninput=\"updateRange(this.value); this.form.submit()\"/>
        </div>
      </div>

      <button type=\"submit\" class=\"apply-btn\">Appliquer</button>
      <a href=\"/offres\" class=\"apply-btn\"
         style=\"display:block;text-align:center;margin-top:8px;background:#eee;color:#333\">
        Réinitialiser
      </a>
    </form>
  </aside>


  {# ── CONTENU PRINCIPAL ──────────────────────────────────────────────────── #}
  <div class=\"main-content\">

    <div class=\"results-bar\">
      <p class=\"results-count\">
        <strong>{{ stats.total_offres ?? 0 }} offre{{ stats.total_offres > 1 ? 's' : '' }}</strong> 
        {{ stats.total_offres > 1 ? 'correspondent' : 'correspond' }} à votre recherche
      </p>
      <div class=\"sort-wrap\">
        <span class=\"sort-label\">Trier par</span>
        <select class=\"sort-select\">
          <option>Plus récentes</option>
          <option>Rémunération ↑</option>
          <option>Rémunération ↓</option>
          <option>Entreprise A–Z</option>
        </select>
      </div>
    </div>

    {# Chips filtres actifs #}
    <div class=\"active-filters\" id=\"activeFilters\">

      {# Durée #}
      {% if filters.duration is defined and filters.duration != '' %}
        <button class=\"chip\" onclick=\"removeChip(this, 'duration')\">
          {{ filters.duration }} <span class=\"chip-x\">×</span>
        </button>
      {% endif %}

      {# Domaines #}
      {% if filters.domain is defined and filters.domain is iterable %}
        {% for domainId in filters.domain %}
          {% for d in domaines %}
            {% if d.id_domain == domainId %}
              <button class=\"chip\" onclick=\"removeChip(this, 'domain', {{ d.id_domain }})\">
                {{ d.name }} <span class=\"chip-x\">×</span>
              </button>
            {% endif %}
          {% endfor %}
        {% endfor %}
      {% endif %}

      {# Ville / localisation #}
      {% if filters.loc is defined and filters.loc != '' %}
        <button class=\"chip\" onclick=\"removeChip(this, 'loc')\">
          {{ filters.loc }} <span class=\"chip-x\">×</span>
        </button>
      {% endif %}

      {# Rémunération max #}
      {% if filters.remu_max is defined and filters.remu_max > 0 and filters.remu_max < 4000 %}
        <button class=\"chip\" onclick=\"removeChip(this, 'remu_max')\">
          Jusqu'à {{ filters.remu_max }} €/mois <span class=\"chip-x\">×</span>
        </button>
      {% endif %}

    </div>

    {# ── Grille des offres ──────────────────────────────────────────────── #}
    <div class=\"offers-grid\">
      {% for offre in offres %}
        <article class=\"offer-card\" data-domain=\"{{ offre.domain|lower }}\">
          <span class=\"domain-badge\">{{ offre.domain ?? '—' }}</span>

          <div class=\"offer-top\">
            <div class=\"offer-company\">
              <div class=\"company-logo\">{{ offre.entreprise|slice(0,2)|upper }}</div>
              <span class=\"company-name\">{{ offre.entreprise }}</span>
            </div>
          </div>

          <p class=\"offer-title\">{{ offre.title }}</p>

          <div class=\"offer-location\">
            <svg viewBox=\"0 0 24 24\" fill=\"currentColor\">
              <path d=\"M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z\"/>
            </svg>
            {{ offre.location }}
          </div>

          <div class=\"offer-tags\">
            {% if offre.skill %}
              {% for tag in offre.skill|split(',') %}
                <span class=\"offer-tag\">{{ tag|trim }}</span>
              {% endfor %}
            {% endif %}
          </div>

          <div class=\"offer-footer\">
            <span class=\"offer-salary\">{{ offre.remuneration ?? 'N/A' }}</span>
            <span class=\"offer-date\">{{ offre.publication_date|date('d/m/Y') }}</span>
            <a href=\"/offres/{{ offre.id_offer }}\" class=\"btn-voir\">Voir</a>
            
            {# Bouton wishlist - uniquement si connecté #}
            {% if app_user %}
              <button class=\"wishlist-btn {% if offre.in_wishlist|default(false) %}active{% endif %}\" 
                      onclick=\"toggleWish(this, {{ offre.id_offer }})\" 
                      aria-label=\"Ajouter aux favoris\"
                      data-offer-id=\"{{ offre.id_offer }}\">
                <svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\"
                     stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">
                  <path d=\"M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z\"/>
                </svg>
              </button>
            {% endif %}
          </div>

        </article>
      {% else %}
        <p style=\"color:#999; grid-column:1/-1; text-align:center; padding:60px 0\">
          Aucune offre ne correspond à votre recherche.
        </p>
      {% endfor %}
    </div>

    {# ── Pagination ─────────────────────────────────────────────────────── #}
    {% if pagination is defined and pagination.total_pages > 1 %}

      <div class=\"pagination\">

        {# Flèche précédente #}
        {% if pagination.current > 1 %}
          <a href=\"{{ path('offres', filters|merge({page: pagination.current - 1})) }}\"
            class=\"page-btn arrow\">‹</a>
        {% endif %}

        {# Pages #}
        {% for p in 1..pagination.total_pages %}
          {% if p == pagination.current %}
            <button class=\"page-btn active\">{{ p }}</button>
          {% elseif p <= 3 or p > pagination.total_pages - 2 or (p >= pagination.current - 1 and p <= pagination.current + 1) %}
            <a href=\"{{ path('offres', filters|merge({page: p})) }}\"
              class=\"page-btn\">{{ p }}</a>
          {% elseif p == 4 or p == pagination.total_pages - 2 %}
            <span style=\"font-weight:700;color:#ccc;padding:0 4px\">…</span>
          {% endif %}
        {% endfor %}

        {# Flèche suivante #}
        {% if pagination.current < pagination.total_pages %}
          <a href=\"{{ path('offres', filters|merge({page: pagination.current + 1})) }}\"
            class=\"page-btn arrow\">›</a>
        {% endif %}

      </div>
    {% endif %}

  </div>{# /main-content #}

</div>{# /layout #}

{% endblock %}

{% block extra_js %}
<script src=\"/assets/js/offer-script.js\"></script>
{% endblock %}", "offre/list.html.twig", "/var/www/stagehub.fr/templates/offre/list.html.twig");
    }
}
