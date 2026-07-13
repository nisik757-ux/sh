<?php
/**
 * HurrahCasino.ch Generator - 180 pages FR + DE
 * Swiss casino affiliate site - Premium 3D design
 */

$OPENAI_KEY = 'OPENAI_KEY_HERE';
$ANTHROPIC_KEY = 'ANTHROPIC_KEY_HERE';

$BASE = '/home/admin/web/hurrahcasino.ch/public_html';
$IMG_DIR = $BASE . '/images';

$AFF = [
    'https://track.smartlink-gh.site/sl?id=687a0b103913fc6f4740965e&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67977ae8d54db995337cdfd9&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67935cda9c50ac5df850a615&pid=3935',
];

foreach (['images','images/fr','images/de','fr','de','fr/bonus','fr/casino','fr/jeux','fr/guide','fr/villes','de/bonus','de/casino','de/spiele','de/guide','de/staedte'] as $d) {
    if (!is_dir($BASE.'/'.$d)) mkdir($BASE.'/'.$d, 0755, true);
}

function claude($prompt, $key, $tokens = 800) {
    $data = json_encode(['model'=>'claude-sonnet-4-6','max_tokens'=>$tokens,'messages'=>[['role'=>'user','content'=>$prompt]]]);
    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$data,CURLOPT_HTTPHEADER=>['Content-Type: application/json','x-api-key: '.$key,'anthropic-version: 2023-06-01'],CURLOPT_TIMEOUT=>60]);
    $r = json_decode(curl_exec($ch),true);
    curl_close($ch);
    $t = trim($r['content'][0]['text'] ?? '');
    return preg_replace('/```html|```/i','',$t);
}

function genImg($prompt, $file, $key, $dir) {
    if (empty($prompt)) return null;
    $path = $dir.'/'.$file;
    $jpg = str_replace('.png','.jpg',$path);
    if (file_exists($jpg)) return str_replace($GLOBALS['BASE'],'',$jpg);
    $data = json_encode(['model'=>'gpt-image-1','prompt'=>$prompt.', professional casino website Swiss luxury, no text','n'=>1,'size'=>'1024x1024','output_format'=>'png']);
    $ch = curl_init('https://api.openai.com/v1/images/generations');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$data,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$key],CURLOPT_TIMEOUT=>90]);
    $r = json_decode(curl_exec($ch),true);
    curl_close($ch);
    if (!isset($r['data'][0]['b64_json'])) return null;
    file_put_contents($path, base64_decode($r['data'][0]['b64_json']));
    $img = imagecreatefrompng($path);
    imagejpeg($img,$jpg,85);
    imagedestroy($img);
    unlink($path);
    return str_replace($GLOBALS['BASE'],'',$jpg);
}

function faqHtml($questions) {
    $html = '';
    foreach ($questions as $q => $a) {
        $html .= '<div class="faq-item"><div class="fq">'.htmlspecialchars($q).' <span class="fi">+</span></div><div class="fa">'.$a.'</div></div>';
    }
    return $html;
}

// ============ CSS ULTRA PREMIUM 3D ============
$CSS = '
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
:root{--red:#D40000;--red2:#FF2A2A;--dark:#080808;--dark2:#111;--dark3:#1a1a1a;--gold:#FFD700;--gold2:#FFA500;--white:#fff;--gray:#888;--glass:rgba(255,255,255,.05);--glass2:rgba(255,255,255,.08);--border:rgba(255,255,255,.1);--border2:rgba(212,0,0,.3)}
html{scroll-behavior:smooth}
body{background:var(--dark);color:var(--white);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;overflow-x:hidden;min-height:100vh}
body::before{content:"";position:fixed;top:0;left:0;right:0;bottom:0;background:radial-gradient(ellipse at 20% 50%,rgba(212,0,0,.08) 0%,transparent 50%),radial-gradient(ellipse at 80% 20%,rgba(255,215,0,.04) 0%,transparent 40%);pointer-events:none;z-index:0}
.topbar{position:sticky;top:0;z-index:100;background:rgba(8,8,8,.97);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);padding:0 20px;height:64px;display:flex;align-items:center;justify-content:space-between}
.logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.logo-icon{width:36px;height:36px;background:linear-gradient(135deg,var(--red),var(--red2));border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 4px 20px rgba(212,0,0,.4)}
.logo-text{font-size:18px;font-weight:800;background:linear-gradient(135deg,#fff,#ccc);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.logo-text span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.nav-desktop{display:none}
@media(min-width:768px){.nav-desktop{display:flex;gap:6px;align-items:center}.nav-desktop a{color:rgba(255,255,255,.7);font-size:14px;font-weight:500;padding:8px 14px;border-radius:8px;transition:.2s;text-decoration:none}.nav-desktop a:hover{background:var(--glass2);color:#fff}.topbar{padding:14px 40px}.section{max-width:1100px;margin:0 auto}}
.topbar-cta{background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:9px 18px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 4px 15px rgba(212,0,0,.35);white-space:nowrap}
.sponsored-label{font-size:9px;font-weight:400;opacity:.7;display:block;text-align:center}
.swiss-divider{height:3px;background:linear-gradient(90deg,transparent,var(--red),#fff,var(--red),transparent)}
.hero{position:relative;overflow:hidden;padding:50px 20px 40px;text-align:center;background:linear-gradient(160deg,#0d0000,#080808)}
.hero::before{content:"";position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:conic-gradient(from 0deg at 50% 50%,transparent 0deg,rgba(212,0,0,.03) 60deg,transparent 120deg);animation:rotate 20s linear infinite;pointer-events:none}
@keyframes rotate{to{transform:rotate(360deg)}}
.hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(212,0,0,.12);border:1px solid rgba(212,0,0,.25);color:#ff6666;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;margin-bottom:20px;position:relative;z-index:1}
.hero h1{font-size:clamp(24px,5vw,50px);font-weight:900;line-height:1.15;margin-bottom:14px;position:relative;z-index:1;background:linear-gradient(135deg,#fff,#ddd);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--red),var(--red2),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero-desc{font-size:15px;color:rgba(255,255,255,.6);max-width:540px;margin:0 auto 24px;line-height:1.65;position:relative;z-index:1}
.hero-btns{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1}
.btn-primary{background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:13px 26px;border-radius:12px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 8px 30px rgba(212,0,0,.4);display:inline-block}
.btn-secondary{border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8);padding:13px 22px;border-radius:12px;font-weight:600;font-size:14px;text-decoration:none;display:inline-block}
.stats-bar{display:flex;overflow-x:auto;gap:0;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.stats-bar::-webkit-scrollbar{display:none}
.stat-item{flex:1;min-width:100px;padding:14px 16px;text-align:center;border-right:1px solid var(--border)}
.stat-num{font-size:20px;font-weight:900;background:linear-gradient(135deg,var(--red),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block}
.stat-lbl{font-size:10px;color:var(--gray);margin-top:2px;font-weight:500}
.trust-strip{display:flex;overflow-x:auto;gap:8px;padding:14px 20px;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.trust-strip::-webkit-scrollbar{display:none}
.trust-badge{flex-shrink:0;display:flex;align-items:center;gap:6px;background:var(--glass);border:1px solid var(--border);border-radius:10px;padding:7px 12px;font-size:11px;font-weight:600;white-space:nowrap}
.section{padding:36px 20px}
.sec-eyebrow{display:inline-block;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--red2);margin-bottom:8px}
.sec-title{font-size:clamp(18px,3vw,28px);font-weight:800;line-height:1.25;margin-bottom:16px}
.sec-title span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.casino-grid{display:grid;grid-template-columns:1fr;gap:12px}
@media(min-width:600px){.casino-grid{grid-template-columns:1fr 1fr}}
@media(min-width:900px){.casino-grid{grid-template-columns:repeat(3,1fr)}}
.casino-card{background:var(--dark2);border:1px solid var(--border);border-radius:16px;overflow:hidden;position:relative;transition:transform .25s,border-color .25s;text-decoration:none;color:var(--white);display:block}
.casino-card:hover{transform:translateY(-4px);border-color:rgba(212,0,0,.4)}
.casino-card-header{padding:16px 14px 10px;display:flex;align-items:center;gap:10px}
.casino-logo{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#8B0000,var(--red));display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
.casino-name{font-size:14px;font-weight:800}
.casino-rating{display:flex;align-items:center;gap:4px;margin-top:2px}
.stars{color:var(--gold);font-size:11px}
.rating-num{font-size:11px;color:var(--gray)}
.casino-badge{position:absolute;top:10px;right:10px;background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;font-size:10px;font-weight:700;padding:3px 8px;border-radius:6px}
.casino-bonus{padding:10px 14px;background:rgba(212,0,0,.06);border-top:1px solid var(--border)}
.bonus-amount{font-size:16px;font-weight:900;background:linear-gradient(135deg,var(--red),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.bonus-desc{font-size:11px;color:var(--gray);margin-top:2px}
.casino-cta{margin:10px 14px 14px;background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:9px;border-radius:9px;font-weight:700;font-size:12px;text-align:center}
.bonus-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
@media(min-width:600px){.bonus-grid{grid-template-columns:repeat(3,1fr)}}
@media(min-width:900px){.bonus-grid{grid-template-columns:repeat(4,1fr)}}
.bonus-pill{background:var(--dark2);border:1px solid var(--border);border-radius:12px;padding:14px 10px;text-align:center;text-decoration:none;color:var(--white);transition:transform .2s,border-color .2s;display:block}
.bonus-pill:hover{transform:translateY(-3px);border-color:var(--border2)}
.bonus-pill-icon{font-size:26px;margin-bottom:6px;display:block}
.bonus-pill-name{font-size:12px;font-weight:700;margin-bottom:3px}
.bonus-pill-amount{font-size:11px;color:var(--red2);font-weight:700}
.cta-section{margin:0 20px 24px;background:linear-gradient(135deg,#1a0000,#0d0000);border:1px solid rgba(212,0,0,.2);border-radius:18px;padding:24px 20px;text-align:center}
.cta-title{font-size:20px;font-weight:900;margin-bottom:4px}
.cta-title span{background:linear-gradient(135deg,var(--red),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.cta-sub{font-size:12px;color:var(--gray);margin-bottom:16px;line-height:1.5}
.cta-btn{display:inline-block;background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:13px 28px;border-radius:11px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 8px 25px rgba(212,0,0,.4)}
.cta-sponsored{font-size:10px;color:var(--gray);margin-top:6px;display:block}
.content-hero{background:linear-gradient(160deg,#0d0000,#080808);padding:36px 20px 24px;border-bottom:1px solid var(--border)}
.content-hero h1{font-size:clamp(19px,4vw,34px);font-weight:900;line-height:1.25;margin-bottom:8px}
.content-hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.content-hero p{font-size:13px;color:var(--gray);line-height:1.65}
.breadcrumb{display:flex;gap:6px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
.breadcrumb a{color:var(--gray);font-size:12px;text-decoration:none}
.breadcrumb span{color:var(--gray);font-size:12px}
.content-body{padding:20px;font-size:13px;line-height:1.75;color:rgba(255,255,255,.85)}
.content-body h2{font-size:17px;font-weight:800;margin:22px 0 10px;color:#fff;border-left:3px solid var(--red);padding-left:10px}
.content-body h3{font-size:15px;font-weight:700;margin:16px 0 8px;color:var(--red2)}
.content-body p{margin-bottom:12px}
.content-body ul,.content-body ol{margin:0 0 12px 18px}
.content-body li{margin-bottom:5px}
.content-body strong{color:#fff}
.content-body a{color:var(--red2);font-weight:600;text-decoration:none}
.faq-item{background:var(--dark2);border-radius:11px;margin-bottom:8px;overflow:hidden;border:1px solid var(--border)}
.fq{padding:13px 16px;font-size:13px;font-weight:600;display:flex;justify-content:space-between;align-items:center;cursor:pointer;line-height:1.4}
.fi{color:var(--red2);font-size:18px;transition:.2s;flex-shrink:0;margin-left:8px}
.faq-item.open .fi{transform:rotate(45deg)}
.fa{font-size:12px;color:var(--gray);line-height:1.6;max-height:0;overflow:hidden;transition:max-height .3s,padding .3s}
.faq-item.open .fa{max-height:300px;padding:0 16px 14px}
.rel-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
@media(min-width:480px){.rel-grid{grid-template-columns:repeat(3,1fr)}}
.rel-card{background:var(--dark2);border-radius:10px;padding:10px;border:1px solid var(--border);display:block;font-size:12px;font-weight:700;text-decoration:none;color:var(--white);line-height:1.4}
.rel-card:hover{border-color:var(--border2)}
.rel-sub{font-size:11px;color:var(--gray);margin-top:3px}
.lang-bar{background:var(--dark3);border-bottom:1px solid var(--border);padding:7px 20px;display:flex;align-items:center;gap:8px}
.lang-btn{display:flex;align-items:center;gap:4px;font-size:12px;font-weight:700;color:var(--gray);text-decoration:none;padding:4px 10px;border-radius:6px;border:1px solid transparent;transition:.2s}
.lang-btn.active,.lang-btn:hover{background:var(--glass2);border-color:var(--border);color:#fff}
.footer{background:var(--dark2);border-top:1px solid var(--border);padding:24px 20px;text-align:center}
.footer-logo{font-size:18px;font-weight:900;margin-bottom:8px}
.footer-logo span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.footer-links{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-bottom:12px}
.footer-links a{color:var(--gray);font-size:12px;text-decoration:none}
.footer-links a:hover{color:var(--red2)}
.footer-disclaimer{font-size:10px;color:rgba(255,255,255,.3);line-height:1.6;max-width:600px;margin:0 auto}
.bottom-nav{position:fixed;bottom:0;left:0;right:0;background:rgba(8,8,8,.97);backdrop-filter:blur(20px);border-top:1px solid var(--border);display:flex;padding:8px 0 max(8px,env(safe-area-inset-bottom));z-index:100}
@media(min-width:768px){.bottom-nav{display:none}body{padding-bottom:0}}
.bn-item{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:var(--gray);font-size:10px;font-weight:600}
.bn-item.active{color:var(--red2)}
.bn-ico{font-size:20px}
';

// NAVS & FOOTERS
$NAV_FR = '<nav class="topbar"><a href="/fr/" class="logo"><div class="logo-icon">🎰</div><div class="logo-text">Hurrah<span>Casino</span></div></a><div class="nav-desktop"><a href="/fr/casino/">Casinos</a><a href="/fr/bonus/">Bonus</a><a href="/fr/jeux/">Jeux</a><a href="/fr/guide/">Guide</a><a href="/de/">🇩🇪 DE</a></div><a href="'.$AFF[0].'" target="_blank" rel="noopener sponsored" class="topbar-cta">Jouer →<span class="sponsored-label">Sponsorisé</span></a></nav>';
$NAV_DE = '<nav class="topbar"><a href="/de/" class="logo"><div class="logo-icon">🎰</div><div class="logo-text">Hurrah<span>Casino</span></div></a><div class="nav-desktop"><a href="/de/casino/">Casinos</a><a href="/de/bonus/">Bonus</a><a href="/de/spiele/">Spiele</a><a href="/de/guide/">Guide</a><a href="/fr/">🇫🇷 FR</a></div><a href="'.$AFF[0].'" target="_blank" rel="noopener sponsored" class="topbar-cta">Spielen →<span class="sponsored-label">Gesponsert</span></a></nav>';
$BNAV_FR = '<nav class="bottom-nav"><a href="/fr/" class="bn-item"><span class="bn-ico">🏠</span>Accueil</a><a href="/fr/casino/" class="bn-item"><span class="bn-ico">🎰</span>Casinos</a><a href="/fr/bonus/" class="bn-item active"><span class="bn-ico">🎁</span>Bonus</a><a href="/fr/jeux/" class="bn-item"><span class="bn-ico">🎮</span>Jeux</a><a href="/fr/guide/" class="bn-item"><span class="bn-ico">📖</span>Guide</a></nav>';
$BNAV_DE = '<nav class="bottom-nav"><a href="/de/" class="bn-item"><span class="bn-ico">🏠</span>Start</a><a href="/de/casino/" class="bn-item"><span class="bn-ico">🎰</span>Casinos</a><a href="/de/bonus/" class="bn-item active"><span class="bn-ico">🎁</span>Bonus</a><a href="/de/spiele/" class="bn-item"><span class="bn-ico">🎮</span>Spiele</a><a href="/de/guide/" class="bn-item"><span class="bn-ico">📖</span>Guide</a></nav>';
$FOOTER_FR = '<footer class="footer"><div class="footer-logo">Hurrah<span>Casino</span>.ch</div><div class="footer-links"><a href="/fr/">Accueil</a><a href="/fr/casino/">Casinos</a><a href="/fr/bonus/">Bonus</a><a href="/fr/jeux/">Jeux</a><a href="/fr/guide/">Guides</a><a href="/de/">Deutsch</a></div><p class="footer-disclaimer">HurrahCasino.ch est un site de comparaison de casinos. Contenu sponsorisé. Le jeu peut créer une dépendance. Interdit aux moins de 18 ans. © '.date('Y').' HurrahCasino.ch</p></footer>';
$FOOTER_DE = '<footer class="footer"><div class="footer-logo">Hurrah<span>Casino</span>.ch</div><div class="footer-links"><a href="/de/">Start</a><a href="/de/casino/">Casinos</a><a href="/de/bonus/">Bonus</a><a href="/de/spiele/">Spiele</a><a href="/de/guide/">Guides</a><a href="/fr/">Français</a></div><p class="footer-disclaimer">HurrahCasino.ch ist eine Casino-Vergleichswebsite. Gesponserter Inhalt. Glücksspiel kann süchtig machen. Nur ab 18 Jahren. © '.date('Y').' HurrahCasino.ch</p></footer>';

// BUILD PAGE FUNCTION
function buildPage($h1, $meta, $breadcrumb, $intro, $body, $faqHtml, $relHtml, $affLink, $imgPath, $nav, $bnav, $footer, $lang='fr') {
    global $CSS;
    $imgTag = $imgPath ? '<img src="'.$imgPath.'" alt="'.htmlspecialchars($h1).'" style="width:100%;height:220px;object-fit:cover;display:block">' : '';
    $langBar = '<div class="lang-bar"><a href="/fr/" class="lang-btn '.($lang==='fr'?'active':'').'">🇨🇭 Français</a><a href="/de/" class="lang-btn '.($lang==='de'?'active':'').'">🇩🇪 Deutsch</a></div>';
    $isDE = $lang==='de';
    $ctaPlay = $isDE ? 'Angebot ansehen →' : 'Voir l\'Offre →';
    $ctaReg = $isDE ? 'Jetzt Registrieren →' : 'S\'inscrire et Jouer →';
    $sponsLabel = $isDE ? 'Gesponserter Link — verantwortungsvoll spielen' : 'Lien sponsorisé — jouez responsablement';
    $offerLabel = $isDE ? 'Gesponsertes Angebot' : 'Offre Sponsorisée';
    $bonusLabel = $isDE ? 'Exklusiver Bonus · Nur ab 18 · Verantwortungsvolles Spielen' : 'Bonus exclusif · +18 uniquement · Jeu responsable';
    return '<!DOCTYPE html><html lang="'.$lang.'"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808"><title>'.htmlspecialchars($h1).' | HurrahCasino.ch</title><meta name="description" content="'.htmlspecialchars($meta).'"><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'</style></head><body>'.$langBar.$nav.$imgTag.'<div class="content-hero"><div class="breadcrumb">'.$breadcrumb.'</div><h1>'.htmlspecialchars($h1).'</h1><p>'.$intro.'</p></div><div class="cta-section" style="margin-top:20px"><div class="cta-title">🎰 <span>'.$offerLabel.'</span></div><div class="cta-sub">'.$bonusLabel.'</div><a href="'.$affLink.'" target="_blank" rel="noopener sponsored" class="cta-btn">'.$ctaPlay.'</a><span class="cta-sponsored">'.$sponsLabel.'</span></div><div class="content-body">'.$body.'</div><div style="padding:0 20px 20px"><div class="sec-title" style="margin-bottom:14px">❓ FAQ</div>'.$faqHtml.'</div><div style="padding:0 20px 20px"><div class="sec-title" style="margin-bottom:14px">'.($isDE?'Siehe Auch':'Voir Aussi').'</div><div class="rel-grid">'.$relHtml.'</div></div>'.$footer.$bnav.'<script>document.querySelectorAll(".fq").forEach(q=>q.addEventListener("click",()=>q.closest(".faq-item").classList.toggle("open")));</script></body></html>';
}

$allPages = [];
$pc = 0;
echo "=== HURRAHCASINO.CH GENERATOR ===\n\n";

// ============ FR BONUS PAGES (40) ============
$FR_BONUS = [
['slug'=>'sans-depot','h1'=>'Bonus Sans Dépôt Casino Suisse — Les Meilleures Offres Gratuites','meta'=>'Bonus casino sans dépôt en Suisse. Jouez gratuitement sans risquer votre argent. Offres vérifiées pour joueurs suisses. Bonus en CHF disponibles.','angle'=>'Les bonus sans dépôt permettent aux joueurs suisses de découvrir un casino sans risque. Explique comment en profiter, conditions en Suisse, quels casinos offrent les meilleures offres en CHF.','img'=>'Swiss casino no deposit bonus golden coins Switzerland red dark luxury'],
['slug'=>'bienvenue','h1'=>'Bonus de Bienvenue Casino Suisse — Doublez votre Premier Dépôt en CHF','meta'=>'Meilleur bonus de bienvenue casino en ligne Suisse. 100% à 200% sur votre premier dépôt en CHF. Comparez les offres et choisissez le meilleur casino suisse.','angle'=>'Guide des bonus de bienvenue pour joueurs suisses. Comparer 100% vs 200%, conditions de mise adaptées au marché suisse, casinos avec licence CFMJ qui offrent les meilleurs welcome bonuses en CHF.','img'=>'Welcome bonus casino Switzerland CHF coins luxury dark premium'],
['slug'=>'free-spins','h1'=>'Free Spins Casino Suisse — Tours Gratuits Sans Conditions Compliquées','meta'=>'Free spins gratuits dans les casinos en ligne suisses. 50 à 500 tours gratuits. Offres vérifiées pour résidents suisses. Jouez maintenant en CHF.','angle'=>'Les free spins sont les bonus les plus populaires en Suisse. Guide des meilleures offres, jeux éligibles (Gates of Olympus, Starburst), conditions de mise réelles, comment retirer ses gains en CHF.','img'=>'Free spins casino Switzerland slot reels golden coins Swiss luxury'],
['slug'=>'free-spins-sans-depot','h1'=>'Free Spins Sans Dépôt Suisse — Jouez Gratuitement Dès Aujourd\'hui','meta'=>'Free spins sans dépôt pour joueurs suisses. Recevez des tours gratuits à l\'inscription. Sans carte bancaire requise. Offres exclusives Suisse.','angle'=>'Différence entre free spins avec et sans dépôt en Suisse. Où trouver de vrais free spins sans dépôt pour résidents suisses, comment les activer, et conditions réelles pour retirer les gains.','img'=>'Free spins no deposit Switzerland Swiss casino golden spinning reels'],
['slug'=>'cashback','h1'=>'Cashback Casino Suisse — Récupérez 10 à 20% de Vos Pertes Chaque Semaine','meta'=>'Cashback casino en Suisse. Récupérez jusqu\'à 20% de vos pertes hebdomadaires. Programme cashback pour joueurs suisses en CHF. Meilleurs casinos.','angle'=>'Le cashback est très apprécié par les joueurs suisses pragmatiques. Explique comment fonctionne le cashback au casino en Suisse, calculs en CHF, casinos qui offrent le meilleur taux.','img'=>'Cashback casino Switzerland money returning Swiss franc weekly premium'],
['slug'=>'rechargement','h1'=>'Bonus de Rechargement Casino Suisse — 50% Extra sur Chaque Dépôt','meta'=>'Bonus rechargement casino en ligne Suisse. Recevez 50% à 100% sur chaque rechargement en CHF. Promotions hebdomadaires pour joueurs suisses.','angle'=>'Les joueurs suisses fidèles méritent plus. Guide des bonus de rechargement disponibles en Suisse, calculs concrets en CHF, comment choisir le casino qui offre le meilleur reload bonus.','img'=>'Reload bonus casino Switzerland weekly promotion Swiss franc extra'],
['slug'=>'vip','h1'=>'Programme VIP Casino Suisse — Avantages Exclusifs pour Grands Joueurs','meta'=>'Programme VIP casino en ligne Suisse. Cashback premium, gestionnaire dédié, limites élevées en CHF. Pour les joueurs sérieux en Suisse.','angle'=>'Les programmes VIP en Suisse offrent des avantages uniques. Pour les joueurs avec des bankrolls importants en CHF. Explique les niveaux VIP, avantages concrets, quel casino suisse a le meilleur programme VIP.','img'=>'VIP casino Switzerland luxury premium golden crown Swiss exclusive'],
['slug'=>'bitcoin','h1'=>'Bonus Bitcoin Casino Suisse — 15% Extra pour Dépôts Crypto depuis la Crypto Valley','meta'=>'Bonus casino Bitcoin en Suisse. Dépôts en BTC, ETH, USDT avec bonus supplémentaire. La Suisse aime la crypto. Guide complet crypto casino suisse.','angle'=>'La Suisse est un hub crypto mondial (Crypto Valley Zug). Guide des bonus Bitcoin pour casinos suisses, pourquoi les joueurs suisses choisissent la crypto, quels casinos offrent les meilleurs bonus crypto.','img'=>'Bitcoin casino Switzerland Crypto Valley Zug dark luxury premium'],
['slug'=>'code-promo','h1'=>'Code Promo Casino Suisse — Codes Exclusifs Vérifiés pour Résidents Suisses','meta'=>'Codes promo casino en ligne Suisse. Activez des bonus exclusifs avec nos codes vérifiés. Valables pour résidents suisses. Mise à jour régulière.','angle'=>'Guide des codes promo casino pour joueurs suisses. Comment utiliser un code promo, où trouver les codes valides, les meilleures offres disponibles avec codes exclusifs en Suisse.','img'=>'Promo code casino Switzerland exclusive code golden unlock Swiss'],
['slug'=>'legal','h1'=>'Casino Légal Suisse — Sites Autorisés par la CFMJ pour Jouer en Sécurité','meta'=>'Casinos en ligne légaux en Suisse. Sites autorisés par la CFMJ. Jouez en sécurité sur des plateformes légales suisses. Guide légalité casino.','angle'=>'La légalité est cruciale pour les joueurs suisses. Explique la réglementation CFMJ, quels casinos sont vraiment légaux en Suisse, pourquoi la légalité protège le joueur.','img'=>'Legal casino Switzerland CFMJ license official Swiss flag regulation'],
['slug'=>'meilleur','h1'=>'Meilleur Casino Suisse — Notre Sélection Vérifiée pour Joueurs Suisses','meta'=>'Le meilleur casino en ligne Suisse. Comparatif complet: bonus, sécurité, paiements CHF, support français. Notre recommandation pour les joueurs suisses.','angle'=>'Guide comparatif pour trouver LE meilleur casino en Suisse. Critères objectifs: licence CFMJ, bonus en CHF, support FR/DE, vitesse de retrait, jeux disponibles. Recommandation basée sur tests réels.','img'=>'Best casino Switzerland comparison test review Swiss luxury premium'],
['slug'=>'twint','h1'=>'Casino avec TWINT Suisse — Payer via l\'Application Mobile Suisse','meta'=>'Casino en ligne Suisse acceptant TWINT. Dépôt et retrait via TWINT. Application de paiement suisse la plus populaire. Guide casino TWINT.','angle'=>'TWINT est LA méthode de paiement suisse par excellence. Guide des casinos qui acceptent TWINT, comment l\'utiliser pour les dépôts et retraits casino, limites TWINT, comparatif avec d\'autres méthodes.','img'=>'TWINT casino Switzerland Swiss payment app deposit mobile premium'],
['slug'=>'chf','h1'=>'Casino Suisse en CHF — Jouez en Francs Suisses Sans Frais de Conversion','meta'=>'Casino en ligne acceptant le CHF. Jouez en francs suisses sans frais de conversion. Meilleurs casinos CHF pour résidents suisses.','angle'=>'Jouer en CHF évite les frais de conversion qui réduisent la valeur des bonus. Guide des casinos qui acceptent vraiment le CHF, avantages concrets, comment éviter les frais cachés.','img'=>'Swiss franc CHF casino no conversion direct payment luxury Swiss'],
['slug'=>'retrait-rapide','h1'=>'Casino Suisse Retrait Rapide — Recevez vos Gains en Moins de 24h','meta'=>'Casinos en ligne Suisse avec retrait rapide. Recevez vos gains en CHF en moins de 24h. Méthodes de retrait rapides disponibles en Suisse.','angle'=>'Les suisses valorisent l\'efficacité. Guide des casinos avec retraits les plus rapides en Suisse, méthodes de paiement les plus rapides (TWINT, virement, crypto), délais réels testés.','img'=>'Fast withdrawal casino Switzerland 24h payment quick Swiss efficiency'],
['slug'=>'geneve','h1'=>'Bonus Casino Genève — Meilleures Offres pour Joueurs Genevois','meta'=>'Bonus casino en ligne pour joueurs de Genève. Casinos acceptant les résidents genevois. Offres en CHF, support français. Guide casino Genève.','angle'=>'Guide spécifique pour les joueurs de Genève. Casinos adaptés aux joueurs genevois bilingues FR/EN, méthodes de paiement disponibles, contexte légal casino à Genève capitale internationale.','img'=>'Geneva casino bonus Switzerland Lake Leman luxury French Swiss'],
['slug'=>'lausanne','h1'=>'Bonus Casino Lausanne — Offres Exclusives pour Joueurs Vaudois','meta'=>'Casino en ligne pour joueurs de Lausanne et du canton de Vaud. Bonus en CHF, support français. Guide casino Lausanne et Romandie.','angle'=>'Guide pour les joueurs de Lausanne et du canton de Vaud. Contexte Romandie, casinos populaires, et comment jouer légalement depuis Vaud avec les meilleures offres en CHF.','img'=>'Lausanne casino Switzerland Vaud Olympic city luxury lake view'],
['slug'=>'berne','h1'=>'Bonus Casino Berne — Casino en Ligne depuis la Capitale Suisse','meta'=>'Casino en ligne pour joueurs de Berne. Offres bonus en CHF, bilingue FR/DE. Guide casino Berne et canton de Berne.','angle'=>'Guide pour les joueurs bilingues de Berne. La capitale suisse bilingue FR/DE a des joueurs avec des besoins spécifiques. Guide des meilleurs casinos avec support dans les deux langues.','img'=>'Bern casino Switzerland capital bilingual luxury golden arcades'],
['slug'=>'romandie','h1'=>'Casino en Ligne Romandie — Top Casinos pour la Suisse Romande','meta'=>'Meilleurs casinos en ligne pour la Suisse Romande. Genève, Lausanne, Fribourg, Neuchâtel, Valais. Support français, bonus en CHF. Guide Romandie.','angle'=>'La Suisse Romande est un marché casino en ligne très actif. Guide complet pour tous les cantons romands, différences régionales, casinos qui servent le mieux les joueurs de Romandie.','img'=>'French Switzerland Romandie casino luxury Alps mountains CHF bonus'],
['slug'=>'200-pourcent','h1'=>'Bonus Casino 200% Suisse — Triplez votre Premier Dépôt en CHF','meta'=>'Bonus casino 200% en Suisse. Triplez votre dépôt avec le meilleur bonus bienvenue suisse. Offres 200% vérifiées. Guide et conditions.','angle'=>'Le bonus 200% est le plus généreux mais aussi le plus complexe. Guide pour comprendre si un 200% vaut vraiment mieux qu\'un 100% en Suisse, calculs concrets en CHF, conditions réelles.','img'=>'200 percent casino bonus Switzerland triple deposit Swiss franc luxury'],
['slug'=>'100-pourcent','h1'=>'Bonus Casino 100% Suisse — Doublez sans Complication','meta'=>'Bonus casino 100% en Suisse. Doublez votre premier dépôt en CHF. Conditions simples, casinos vérifiés. Le bonus le plus populaire en Suisse.','angle'=>'Le bonus 100% est le plus populaire en Suisse car équilibre entre générosité et conditions raisonnables. Explique pourquoi, compare les meilleures offres 100% disponibles en Suisse.','img'=>'100 percent casino bonus Switzerland double deposit simple fair'],
['slug'=>'mobile','h1'=>'Bonus Casino Mobile Suisse — Jouez sur iPhone et Android','meta'=>'Bonus casino mobile en Suisse. Offres exclusives pour smartphones. iPhone et Android. Applications casino suisses. Jouez partout en Suisse.','angle'=>'Les suisses jouent massivement sur mobile. Guide des bonus exclusifs mobile en Suisse, meilleures applications casino suisses, et pourquoi les bonus mobile peuvent être plus avantageux.','img'=>'Mobile casino Switzerland iPhone Android bonus app Swiss premium'],
['slug'=>'crypto','h1'=>'Casino Crypto Suisse — Bitcoin et USDT dans la Crypto Valley','meta'=>'Casino crypto en Suisse. Bitcoin, USDT, Ethereum. La Crypto Valley suisse rencontre le casino en ligne. Guide complet crypto casino suisse.','angle'=>'La Suisse est mondialement connue pour la Crypto Valley de Zoug. Les joueurs suisses sont parmi les plus avancés en crypto. Guide des casinos crypto en Suisse, avantages réglementaires.','img'=>'Crypto Valley Zug Switzerland Bitcoin casino blockchain luxury modern'],
['slug'=>'tournoi','h1'=>'Tournois Casino Suisse — Compétitions avec de Vrais Prix en CHF','meta'=>'Tournois casino en ligne Suisse. Compétitions de slots et blackjack avec prizes pools. Leaderboards suisses. Guide tournois casino Suisse.','angle'=>'Les tournois casino attirent les joueurs compétitifs suisses. Guide des tournois disponibles en Suisse, comment s\'y classer, prizes en CHF, et stratégies pour maximiser ses chances.','img'=>'Casino tournament Switzerland leaderboard competition prizes Swiss trophy'],
['slug'=>'parrainage','h1'=>'Bonus Parrainage Casino Suisse — Gagnez en Invitant vos Amis','meta'=>'Programme parrainage casino en ligne Suisse. Invitez vos amis et recevez des bonus en CHF. Meilleures offres de parrainage casino suisse.','angle'=>'Le parrainage est excellent pour les joueurs suisses sociaux. Guide des meilleurs programmes de parrainage casino en Suisse, calcul des gains par ami, quels casinos offrent les meilleures récompenses.','img'=>'Referral casino Switzerland friends bonus sharing Swiss community'],
['slug'=>'sans-verification','h1'=>'Casino Suisse Sans Vérification — Jouez Plus Vite sans KYC Complexe','meta'=>'Casinos en ligne en Suisse avec vérification minimale. Commencez à jouer rapidement sans documents complexes. Guide casino Suisse sans KYC strict.','angle'=>'Beaucoup de joueurs suisses veulent jouer rapidement sans paperasse. Guide des casinos avec KYC minimal disponibles en Suisse, limites sans vérification, quand la vérification devient nécessaire.','img'=>'Casino no verification Switzerland fast play minimal KYC Swiss'],
['slug'=>'aviator','h1'=>'Aviator Casino Suisse — Jouer au Jeu le Plus Populaire de Suisse','meta'=>'Jouer à Aviator dans un casino suisse. Guide stratégies Aviator, bonus Aviator Suisse, meilleurs casinos. Aviator en CHF depuis la Suisse.','angle'=>'Aviator est populaire en Suisse pour sa simplicité et ses gains rapides. Guide Aviator spécifique à la Suisse: stratégies cashout, montants recommandés en CHF, casinos suisses avec le meilleur Aviator.','img'=>'Aviator casino game Switzerland airplane multiplier Swiss luxury dark'],
['slug'=>'blackjack','h1'=>'Blackjack Casino Suisse — Stratégie de Base et Meilleurs Sites','meta'=>'Blackjack en ligne en Suisse. Guide stratégie de base, meilleurs casinos blackjack suisses, bonus blackjack. Jouez au blackjack live depuis la Suisse.','angle'=>'Le blackjack attire les joueurs suisses analytiques. Guide blackjack adapté à la Suisse: où jouer avec le meilleur RTP, règles spécifiques, et stratégie de base expliquée en détail.','img'=>'Blackjack casino Switzerland cards dealer strategy Swiss luxury live'],
['slug'=>'roulette','h1'=>'Roulette Casino Suisse — Roulette Européenne en CHF','meta'=>'Roulette en ligne en Suisse. Roulette européenne et française. Meilleurs casinos roulette suisses, bonus roulette. Jouez en CHF depuis la Suisse.','angle'=>'La roulette est un classique suisse. Guide roulette en Suisse: différences roulette européenne/française, stratégies adaptées, meilleurs casinos live roulette disponibles.','img'=>'Roulette casino Switzerland European wheel luxury elegant Swiss CHF'],
['slug'=>'slots','h1'=>'Machines à Sous Casino Suisse — 500+ Slots Disponibles en CHF','meta'=>'Meilleures machines à sous en ligne Suisse. Gates of Olympus, Sweet Bonanza, Book of Dead. Bonus slots suisses. Jouez aux meilleurs slots en CHF.','angle'=>'Les slots sont les jeux les plus populaires en Suisse. Guide des meilleurs slots disponibles, bonus spécifiques aux machines à sous, RTP adapté aux attentes des joueurs suisses.','img'=>'Slot machines casino Switzerland Gates Olympus Sweet Bonanza luxury'],
['slug'=>'live','h1'=>'Casino Live Suisse — Vrais Croupiers en Direct depuis Chez Vous','meta'=>'Casino live en ligne Suisse. Baccarat, blackjack, roulette avec de vrais croupiers. Tables en CHF disponibles. Meilleur casino live suisse.','angle'=>'Le casino live remplace l\'expérience du Casino de Berne ou de Genève depuis chez soi. Guide casino live en Suisse: meilleures tables disponibles, connexion requise, croupiers francophones.','img'=>'Live casino Switzerland real dealer stream luxury Swiss French'],
['slug'=>'baccarat','h1'=>'Baccarat Casino Suisse — Jeu Préféré des Joueurs Suisses','meta'=>'Baccarat en ligne en Suisse. Guide règles, stratégie, meilleurs casinos baccarat suisses. Baccarat live en CHF depuis la Suisse.','angle'=>'Le baccarat est très populaire dans les casinos terrestres suisses. Guide pour transposer cette expérience en ligne: règles du baccarat, stratégies, meilleurs casinos live baccarat depuis la Suisse.','img'=>'Baccarat casino Switzerland luxury table cards chips elegant Swiss'],
['slug'=>'paiement','h1'=>'Méthodes de Paiement Casino Suisse — TWINT, CHF, Crypto et Plus','meta'=>'Méthodes de paiement casino en ligne Suisse. TWINT, virement bancaire CHF, cartes, crypto. Guide complet paiement casino suisse.','angle'=>'Les suisses ont des méthodes de paiement uniques (TWINT). Guide des options disponibles dans les casinos en Suisse: TWINT, PostFinance, virement CHF, cartes suisses, crypto.','img'=>'Casino payment Switzerland TWINT CHF bank transfer Swiss methods'],
['slug'=>'jackpot','h1'=>'Jackpot Casino Suisse — Gagnez des Millions en CHF','meta'=>'Casinos jackpot en ligne Suisse. Jackpots progressifs en CHF disponibles pour résidents suisses. Mega Fortune, Hall of Gods. Guide jackpot suisse.','angle'=>'Les jackpots progressifs attirent les rêveurs suisses. Guide des jackpots disponibles en Suisse, comment y participer, probabilités réelles, et cas de gagnants suisses notables.','img'=>'Jackpot casino Switzerland millions CHF progressive Swiss dream winner'],
['slug'=>'gratis-bonus','h1'=>'Bonus Gratis Casino Suisse — Jouez Sans Risque Financier','meta'=>'Bonus gratuits casino en Suisse. Free spins gratuits, argent gratuit sans dépôt. Toutes les offres gratuites disponibles pour résidents suisses.','angle'=>'Panorama de toutes les offres gratuites pour les joueurs suisses: bonus sans dépôt, free spins gratuits, tours démo. Comment distinguer les vraies offres gratuites des conditions trop contraignantes.','img'=>'Free bonus casino Switzerland no risk gratis Swiss franc gift luxury'],
['slug'=>'avis','h1'=>'Avis Casinos Suisse — Notre Test Indépendant des Meilleures Plateformes','meta'=>'Avis et tests indépendants des casinos en ligne suisses. Notre équipe teste chaque casino pour les joueurs suisses. Classement et recommandations.','angle'=>'Les joueurs suisses sont exigeants et veulent des avis fiables. Guide de nos tests de casinos suisses: méthodologie, critères d\'évaluation, et résultats pour les résidents suisses.','img'=>'Casino review Switzerland test independent rating Swiss expert'],
['slug'=>'securite','h1'=>'Sécurité Casino Suisse — Jouer sur des Sites 100% Sécurisés','meta'=>'Sécurité des casinos en ligne suisses. Licence CFMJ, SSL, protection des données. Comment jouer en sécurité depuis la Suisse. Guide sécurité casino.','angle'=>'Les suisses sont très soucieux de sécurité. Guide sécurité casino Suisse: comprendre la licence CFMJ, vérifier le SSL, protection RGPD, et reconnaître les casinos frauduleux ciblant les suisses.','img'=>'Casino security Switzerland safe lock protection Swiss flag official'],
['slug'=>'inscription','h1'=>'S\'Inscrire dans un Casino Suisse — Guide Étape par Étape','meta'=>'Comment s\'inscrire dans un casino en ligne suisse. Étapes simples, documents requis, vérification suisse. Guide inscription casino pour résidents suisses.','angle'=>'Guide complet d\'inscription dans un casino suisse. Étapes, documents d\'identité suisse requis, vérification d\'âge, et comment activer son bonus dès l\'inscription.','img'=>'Casino registration Switzerland sign up steps easy Swiss guide'],
['slug'=>'responsable','h1'=>'Jeu Responsable Casino Suisse — Jouer sans Addiction','meta'=>'Jeu responsable dans les casinos en ligne suisses. Limites, autoexclusion, resources. Addictionsuisse et outils de protection pour joueurs suisses.','angle'=>'La Suisse prend le jeu responsable très au sérieux avec Addictionsuisse. Guide jeu responsable spécifique à la Suisse: outils disponibles, AutoExclusion nationale, ressources de soutien en FR et DE.','img'=>'Responsible gambling Switzerland balance protection support Swiss'],
['slug'=>'nouveau','h1'=>'Nouveau Casino Suisse — Sites Récents avec les Meilleurs Bonus','meta'=>'Nouveaux casinos en ligne en Suisse. Sites récents avec bonus de lancement exclusifs. Découvrez les dernières plateformes pour joueurs suisses.','angle'=>'Les nouveaux casinos en Suisse offrent souvent des bonus de lancement très généreux. Guide des dernières plateformes disponibles pour les suisses, comment évaluer un nouveau casino.','img'=>'New casino Switzerland launch bonus exclusive fresh modern platform'],
['slug'=>'postfinance','h1'=>'Casino PostFinance Suisse — Payer Directement via la Banque Postale','meta'=>'Online Casino avec PostFinance Zahlung in der Schweiz. Schweizer Bankkonto direkt nutzen. Einzahlung und Auszahlung per PostFinance. Leitfaden.','angle'=>'PostFinance est unique pour la Suisse. Guide des casinos qui acceptent PostFinance, comment l\'utiliser pour casino, et pourquoi c\'est pratique pour les joueurs suisses.','img'=>'PostFinance casino Switzerland Swiss post bank payment direct CHF'],
];

echo "🎁 FR BONUS PAGES (".count($FR_BONUS).")\n\n";

foreach ($FR_BONUS as $page) {
    $pc++;
    $dir = $BASE.'/fr/bonus/'.$page['slug'];
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    echo "[".$pc."] ".$page['h1']."\n";

    $imgPath = genImg($page['img'], $page['slug'].'.png', $OPENAI_KEY, $IMG_DIR.'/fr');

    $intro = claude("2 phrases d'accroche percutantes pour joueurs suisses: \"".$page['h1']."\"\nAngle: ".$page['angle']."\nMentionne Suisse, CHF si pertinent. SEULEMENT 2 phrases.", $ANTHROPIC_KEY, 150);

    $body = claude("Expert casino suisse. Article UNIQUE: \"".$page['h1']."\"\nAngle: ".$page['angle']."\nContexte: CHF, CFMJ, joueurs suisses premium, Romandie.\n4 sections <h2>, 700-900 mots, données concrètes, exemples CHF. Vendeur et honnête. Pas d'année. Seulement HTML.", $ANTHROPIC_KEY, 1500);

    $faqData = [
        "Ce bonus est-il disponible pour les résidents suisses?" => claude("2 phrases: \"Ce bonus est-il disponible pour les résidents suisses?\" Contexte: ".$page['h1'].". Honnête et rassurant.", $ANTHROPIC_KEY, 100),
        "Les gains du bonus peuvent-ils être retirés en CHF?" => claude("2 phrases vendeuses sur le retrait des gains en CHF depuis la Suisse.", $ANTHROPIC_KEY, 100),
        "Ce casino possède-t-il une licence CFMJ valide?" => claude("2 phrases sur la licence CFMJ et la sécurité pour joueurs suisses.", $ANTHROPIC_KEY, 100),
    ];

    $relHtml = '';
    foreach (array_slice($FR_BONUS, 0, 6) as $rp) {
        if ($rp['slug'] === $page['slug']) continue;
        $relHtml .= '<a href="/fr/bonus/'.$rp['slug'].'/" class="rel-card">'.htmlspecialchars($rp['h1']).'<div class="rel-sub">Bonus Casino Suisse 🇨🇭</div></a>';
        if (substr_count($relHtml,'rel-card') >= 4) break;
    }

    $breadcrumb = '<a href="/fr/">Accueil</a><span>›</span><a href="/fr/bonus/">Bonus</a><span>›</span><span>'.htmlspecialchars($page['slug']).'</span>';
    $html = buildPage($page['h1'],$page['meta'],$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_FR,$BNAV_FR,$FOOTER_FR,'fr');
    file_put_contents($dir.'/index.html', $html);
    $allPages[] = 'fr/bonus/'.$page['slug'].'/';
    echo "  ✅\n";
    sleep(1);
}

// ============ DE BONUS PAGES (40) ============
$DE_BONUS = [
['slug'=>'ohne-einzahlung','h1'=>'Casino Bonus Ohne Einzahlung Schweiz — Gratis Spielen ohne Risiko','meta'=>'Casino Bonus ohne Einzahlung in der Schweiz. Gratis spielen ohne Risiko. Verifizierte Angebote für Schweizer Spieler in CHF. Jetzt spielen.','angle'=>'No-Deposit-Boni ermöglichen Schweizer Spielern ein Casino ohne Risiko auszuprobieren. Erkläre wie man davon profitiert, welche Bedingungen gelten, welche Casinos die besten Angebote ohne Einzahlung in CHF haben.','img'=>'Swiss casino no deposit bonus German Schweiz gratis CHF luxury dark'],
['slug'=>'willkommensbonus','h1'=>'Willkommensbonus Casino Schweiz — 100% bis 200% auf die erste Einzahlung','meta'=>'Bester Willkommensbonus online Casino Schweiz. 100% bis 200% auf Ihre erste Einzahlung in CHF. Vergleich für Schweizer Spieler.','angle'=>'Willkommensboni für Schweizer Spieler vergleichen. 100% vs 200% Bonus, Umsatzbedingungen auf dem Schweizer Markt, CFMJ-lizenzierte Casinos mit den besten Willkommensangeboten in CHF.','img'=>'Welcome bonus casino Schweiz CHF 200 percent German luxury Swiss'],
['slug'=>'freispiele','h1'=>'Freispiele Ohne Einzahlung Schweiz — Gratis Drehen Sofort Verfügbar','meta'=>'Freispiele ohne Einzahlung für Schweizer Spieler. 50 bis 500 Gratis-Spins. Verifizierte Angebote. Spielen Sie jetzt kostenlos in der Schweiz.','angle'=>'Freispiele sind der beliebteste Bonustyp in der Schweiz. Leitfaden für die besten Freispiel-Angebote, berechtigte Spiele, echte Umsatzbedingungen und wie man Gewinne in CHF auszahlen lässt.','img'=>'Free spins casino Switzerland German Freispiele golden reels Swiss'],
['slug'=>'freispiele-ohne-einzahlung','h1'=>'Casino Freispiele Ohne Einzahlung Schweiz — Sofort nach Anmeldung','meta'=>'Echte Freispiele ohne Einzahlung für Schweizer Spieler. Direkt nach der Registrierung verfügbar. Keine Kreditkarte erforderlich. Alle Angebote geprüft.','angle'=>'Unterschied zwischen Freispielen mit und ohne Einzahlung in der Schweiz. Wo man echte No-Deposit-Freispiele findet, wie man sie aktiviert, und die echten Bedingungen für Auszahlungen.','img'=>'No deposit free spins Switzerland German casino gratis instant Swiss'],
['slug'=>'cashback','h1'=>'Cashback Casino Schweiz — 10 bis 20% Ihrer Verluste Wöchentlich Zurück','meta'=>'Cashback Casino Schweiz. Erhalten Sie wöchentlich bis zu 20% Ihrer Verluste zurück. Cashback-Programme für Schweizer Spieler in CHF.','angle'=>'Cashback ist bei pragmatischen Schweizer Spielern sehr beliebt. Erkläre wie Casino-Cashback in der Schweiz funktioniert, Berechnungen in CHF, Casinos mit dem besten Cashback-Satz.','img'=>'Cashback casino Schweiz German Swiss franc money back weekly'],
['slug'=>'reload-bonus','h1'=>'Reload Bonus Casino Schweiz — 50% Extra auf jede Einzahlung','meta'=>'Reload Bonus online Casino Schweiz. 50% bis 100% auf jede Einzahlung in CHF. Wöchentliche Aktionen für Schweizer Spieler.','angle'=>'Reload-Boni belohnen treue Schweizer Spieler. Leitfaden für verfügbare Reload-Boni in der Schweiz, konkrete CHF-Berechnungen, welches Casino den besten regelmäßigen Reload-Bonus anbietet.','img'=>'Reload bonus casino Switzerland German weekly CHF extra Swiss'],
['slug'=>'vip','h1'=>'VIP Casino Schweiz — Exklusive Vorteile für Großspieler in CHF','meta'=>'VIP-Programm online Casino Schweiz. Premium-Cashback, persönlicher Manager, hohe Limits in CHF. Für ernsthafte Spieler in der Schweiz.','angle'=>'VIP-Programme in der Schweiz bieten einzigartige Vorteile für Spieler mit großen Bankrolls in CHF. Erkläre die VIP-Levels, konkrete Vorteile, und welches Schweizer Casino das beste VIP-Programm hat.','img'=>'VIP casino Switzerland German luxury premium crown CHF exclusive'],
['slug'=>'bitcoin','h1'=>'Bitcoin Casino Schweiz — 15% Extra für Krypto-Einzahlungen aus dem Crypto Valley','meta'=>'Bitcoin Casino Bonus Schweiz. Einzahlungen in BTC, ETH, USDT mit Zusatzbonus. Die Schweiz liebt Krypto. Kompletter Leitfaden Krypto Casino Schweiz.','angle'=>'Die Schweiz ist ein weltweites Krypto-Zentrum (Crypto Valley Zug). Leitfaden für Bitcoin-Boni in Schweizer Casinos, warum Schweizer Spieler Krypto wählen, welche Casinos die besten Krypto-Boni bieten.','img'=>'Bitcoin casino Crypto Valley Zug Switzerland German dark luxury'],
['slug'=>'bonus-code','h1'=>'Casino Bonus Code Schweiz — Exklusive Codes für Schweizer Spieler','meta'=>'Casino Bonus Codes Schweiz. Aktivieren Sie exklusive Boni mit unseren geprüften Codes. Gültig für Schweizer Spieler. Regelmäßig aktualisiert.','angle'=>'Leitfaden für Casino Bonus Codes für Schweizer Spieler. Wie man einen Promo-Code verwendet, wo man gültige Codes findet, die besten aktuellen Angebote mit exklusiven Codes in der Schweiz.','img'=>'Promo code casino Switzerland German exclusive unlock golden Swiss'],
['slug'=>'legal','h1'=>'Legales Online Casino Schweiz — Lizenzierte Sites der CFMJ','meta'=>'Legale Online Casinos in der Schweiz. Von der CFMJ zugelassene Seiten. Spielen Sie sicher auf legalen Schweizer Plattformen. CFMJ Leitfaden.','angle'=>'Legalität ist für Schweizer Spieler entscheidend. Erkläre die CFMJ-Regulierung, welche Casinos wirklich legal in der Schweiz sind, warum Legalität den Spieler schützt.','img'=>'Legal casino Switzerland CFMJ license official German regulation Swiss'],
['slug'=>'serioes','h1'=>'Seriöses Online Casino Schweiz — Vertrauenswürdige Plattformen Geprüft','meta'=>'Seriöse Online Casinos in der Schweiz. Geprüfte Plattformen mit CFMJ-Lizenz. Spielen Sie sicher. Unser Leitfaden für vertrauenswürdige Schweizer Casinos.','angle'=>'Schweizer Spieler sind sehr anspruchsvoll in Bezug auf Seriosität. Leitfaden für seriöse Casinos in der Schweiz: Prüfkriterien, Warnzeichen für unseriöse Plattformen, zuverlässige Empfehlungen.','img'=>'Serious trustworthy casino Switzerland German reliable expert Swiss'],
['slug'=>'twint','h1'=>'Casino mit TWINT Schweiz — Einzahlen per Schweizer App','meta'=>'Online Casino in der Schweiz mit TWINT. Einzahlen und Auszahlen per TWINT. Die beliebteste Schweizer Zahlungs-App. Casino TWINT Leitfaden.','angle'=>'TWINT ist DIE Schweizer Zahlungsmethode schlechthin. Leitfaden für Casinos die TWINT akzeptieren, wie man es für Ein- und Auszahlungen verwendet, TWINT-Limits, Vergleich mit anderen Methoden.','img'=>'TWINT casino Switzerland German Swiss payment app deposit mobile'],
['slug'=>'sofortauszahlung','h1'=>'Casino Sofortauszahlung Schweiz — Gewinne in 24h Erhalten','meta'=>'Online Casinos Schweiz mit schneller Auszahlung. Gewinne in CHF in weniger als 24h erhalten. Schnellste Auszahlungsmethoden in der Schweiz.','angle'=>'Schweizer schätzen Effizienz. Leitfaden für Casinos mit den schnellsten Auszahlungen in der Schweiz, schnellste Zahlungsmethoden (TWINT, Überweisung, Krypto), tatsächlich getestete Zeiten.','img'=>'Fast withdrawal casino Switzerland German 24h payment efficiency Swiss'],
['slug'=>'chf','h1'=>'Online Casino CHF Schweiz — Spielen in Schweizer Franken ohne Gebühren','meta'=>'Online Casino mit CHF in der Schweiz. Spielen in Schweizer Franken ohne Wechselkursgebühren. Beste CHF-Casinos für Schweizer Spieler.','angle'=>'In CHF zu spielen vermeidet Wechselkursgebühren. Leitfaden für Casinos, die wirklich CHF akzeptieren, konkrete Vorteile, und wie man versteckte Konversionsgebühren vermeidet.','img'=>'Swiss franc CHF casino Germany no conversion direct Swiss payment'],
['slug'=>'zuerich','h1'=>'Casino Bonus Zürich — Beste Angebote für Zürcher Spieler','meta'=>'Online Casino Bonus für Spieler in Zürich. Casinos für Zürcher, CHF, deutsch/französischer Support. Casino Zürich Leitfaden online.','angle'=>'Leitfaden speziell für Spieler in Zürich, der wirtschaftlichen Hauptstadt. Casinos angepasst an Zürcher zweisprachige Spieler DE/FR, lokale Zahlungsmethoden, rechtlicher Kontext.','img'=>'Zurich casino bonus Germany Switzerland CHF premium economic capital'],
['slug'=>'bern','h1'=>'Casino Online Bern — Beste Boni für Berner Spieler','meta'=>'Online Casino für Spieler in Bern. Zweisprachig DE/FR, CHF Boni. Casino Bern und Kanton Bern Leitfaden. Legale Casinos für Berner Spieler.','angle'=>'Leitfaden für zweisprachige Spieler in Bern. Berns Hauptstadt mit DE/FR Spielern mit spezifischen Bedürfnissen. Beste Casinos mit Support in beiden Sprachen und CHF-Zahlungen.','img'=>'Bern casino Switzerland capital bilingual German French Swiss bonus'],
['slug'=>'basel','h1'=>'Casino Basel Online — Top Angebote für Basler Spieler am Dreiländereck','meta'=>'Online Casino für Spieler in Basel. Grenznähe D/F, CHF und EUR akzeptiert. Casino Basel online Leitfaden. Beste Casinos für Basler Spieler.','angle'=>'Basel liegt an der Dreiländerecke CH/DE/FR. Basler Spieler haben Zugang zu Casinos in drei Ländern. Guide speziell für Basler: Vor- und Nachteile Schweizer vs. deutsche Casinos.','img'=>'Basel casino Switzerland tripoint border Germany France Swiss premium'],
['slug'=>'bestes-casino','h1'=>'Bestes Online Casino Schweiz — Unser Test der Top-Plattformen','meta'=>'Das beste Online Casino in der Schweiz. Vollständiger Vergleich: Boni, Sicherheit, CHF-Zahlungen, Deutsch-Support. Empfehlung für Schweizer Spieler.','angle'=>'Vergleichsleitfaden für DAS beste Casino in der Schweiz. Objektive Kriterien: CFMJ-Lizenz, CHF-Boni, DE-Support, Auszahlungsgeschwindigkeit. Empfehlung basierend auf echten Tests.','img'=>'Best casino Switzerland German test review expert Swiss premium'],
['slug'=>'neu','h1'=>'Neue Online Casinos Schweiz — Frische Plattformen mit Top-Boni','meta'=>'Neue Online Casinos in der Schweiz. Neueste Plattformen mit Einführungsboni. Entdecken Sie die aktuellsten Schweizer Online-Casinos.','angle'=>'Neue Casinos in der Schweiz bieten oft sehr großzügige Einführungsboni. Leitfaden für die neuesten verfügbaren Plattformen für Schweizer Spieler, Bewertung neuer Casinos.','img'=>'New casino Switzerland German fresh launch bonus modern platform'],
['slug'=>'krypto','h1'=>'Krypto Casino Schweiz — Bitcoin und USDT im Crypto Valley Zug','meta'=>'Krypto Casino in der Schweiz. Bitcoin, USDT, Ethereum. Das Schweizer Crypto Valley trifft das Online Casino. Kompletter Krypto Casino Leitfaden.','angle'=>'Die Schweiz ist weltbekannt für das Crypto Valley Zug. Schweizer Spieler sind unter den fortschrittlichsten in Krypto. Leitfaden für Krypto Casinos, regulatorische Vorteile, beste Angebote.','img'=>'Crypto Valley Zug Switzerland Bitcoin casino German blockchain luxury'],
['slug'=>'gratis-bonus','h1'=>'Gratis Casino Bonus Schweiz — Kostenlos Spielen Ohne Risiko','meta'=>'Gratis Boni im Casino in der Schweiz. Kostenlose Freispiele, Geld ohne Einzahlung. Alle kostenlosen Angebote für Schweizer Spieler.','angle'=>'Überblick über alle kostenlosen Angebote für Schweizer Spieler: No-Deposit-Boni, kostenlose Freispiele, Demo-Runden. Wie man echte von solchen mit zu strengen Bedingungen unterscheidet.','img'=>'Free bonus casino Switzerland German gratis no risk CHF gift luxury'],
['slug'=>'einzahlungsbonus','h1'=>'Einzahlungsbonus Casino Schweiz — Maximale Bonusse auf jede Einzahlung','meta'=>'Einzahlungsboni Online Casino Schweiz. 100% bis 200% auf Ihre Einzahlungen in CHF. Alle Einzahlungsboni für Schweizer Spieler verglichen.','angle'=>'Kompletter Leitfaden für alle Einzahlungsboni in der Schweiz: erster, zweiter, dritter Bonus. Wie man jeden maximiert, Umsatzbedingungen versteht und in CHF optimal spielt.','img'=>'Deposit bonus casino Switzerland German all deposits CHF maximum'],
['slug'=>'mobile','h1'=>'Mobile Casino Bonus Schweiz — Spielen auf iPhone und Android','meta'=>'Mobile Casino Bonus in der Schweiz. Exklusive Angebote für Smartphones. iPhone und Android. Beste Casino-Apps für Schweizer Spieler.','angle'=>'Schweizer spielen massiv auf Mobilgeräten. Leitfaden für exklusive Mobile-Boni in der Schweiz, beste Casino-Apps, und warum Mobile-Boni manchmal vorteilhafter sein können.','img'=>'Mobile casino Switzerland German iPhone Android bonus app Swiss'],
['slug'=>'automaten','h1'=>'Spielautomaten Casino Schweiz — 500+ Slots mit Top-Boni','meta'=>'Beste Spielautomaten Online Casino Schweiz. Gates of Olympus, Book of Dead, Sweet Bonanza. Slots Boni für Schweizer Spieler in CHF.','angle'=>'Spielautomaten sind die beliebtesten Spiele in der Schweiz. Leitfaden für die besten verfügbaren Slots, spezifische Automaten-Boni, RTP angepasst an Schweizer Spieler.','img'=>'Slot machines casino Schweiz Gates Olympus Book Dead German Swiss'],
['slug'=>'blackjack','h1'=>'Blackjack Casino Schweiz — Grundstrategie und Beste Seiten','meta'=>'Blackjack online in der Schweiz. Grundstrategie-Leitfaden, beste Schweizer Blackjack Casinos, Blackjack Boni. Live Blackjack in CHF.','angle'=>'Blackjack spricht analytische Schweizer Spieler an. Leitfaden für Blackjack in der Schweiz: wo man mit dem besten RTP spielt, spezifische Regeln, und Grundstrategie detailliert erklärt.','img'=>'Blackjack casino Switzerland German cards strategy live Swiss CHF'],
['slug'=>'roulette','h1'=>'Roulette Casino Schweiz — Europäisches Roulette in CHF Spielen','meta'=>'Roulette online in der Schweiz. Europäisches und französisches Roulette. Beste Schweizer Roulette-Casinos. In CHF aus der Schweiz spielen.','angle'=>'Roulette ist ein Schweizer Klassiker. Leitfaden für Roulette in der Schweiz: Unterschiede europäisches/französisches Roulette, Strategien, beste Live-Roulette-Casinos.','img'=>'Roulette casino Switzerland German European wheel luxury elegant CHF'],
['slug'=>'baccarat','h1'=>'Baccarat Casino Schweiz — Live Baccarat auf Deutsch','meta'=>'Baccarat online in der Schweiz. Regeln, Strategie, beste Schweizer Baccarat Casinos. Live Baccarat in CHF. Auf Deutsch verfügbar.','angle'=>'Baccarat ist in Schweizer Landcasinos sehr beliebt. Leitfaden für Online-Baccarat: Regeln, Strategien, beste Live-Baccarat-Casinos mit deutschsprachigem Support.','img'=>'Baccarat casino Switzerland German luxury table cards live elegant'],
['slug'=>'jackpot','h1'=>'Jackpot Casino Schweiz — Millionen Gewinnen in CHF','meta'=>'Jackpot Casinos online Schweiz. Progressive Jackpots in CHF für Schweizer Spieler. Mega Fortune, Hall of Gods. Jackpot Casino Schweiz Leitfaden.','angle'=>'Progressive Jackpots faszinieren Schweizer Träumer. Leitfaden für verfügbare Jackpots in der Schweiz, wie man teilnimmt, echte Wahrscheinlichkeiten, bekannte Schweizer Jackpot-Gewinner.','img'=>'Jackpot casino Switzerland German millions CHF progressive Swiss'],
['slug'=>'empfehlung','h1'=>'Casino Empfehlung Schweiz — Unsere Top-Picks für Schweizer Spieler','meta'=>'Casino Empfehlungen für Schweizer Spieler. Unsere besten Online Casinos für die Schweiz. Getestet und verifiziert. Empfehlungen auf Deutsch.','angle'=>'Leitfaden für unsere Top-Casino-Empfehlungen für Schweizer Spieler. Auswahlkriterien: CFMJ-Lizenz, CHF-Boni, DE-Support, Auszahlungsgeschwindigkeit. Ehrliche Empfehlungen basierend auf echten Tests.','img'=>'Casino recommendation Switzerland German top pick expert Swiss'],
['slug'=>'aviator','h1'=>'Aviator Casino Schweiz — Das Beliebteste Spiel Spielen','meta'=>'Aviator im Schweizer Casino spielen. Strategien Aviator, Aviator Boni Schweiz, beste Casinos. Aviator in CHF aus der Schweiz.','angle'=>'Aviator ist in der Schweiz wegen seiner Einfachheit und schnellen Gewinne beliebt. Aviator-Leitfaden speziell für die Schweiz: Cashout-Strategien, empfohlene CHF-Beträge, Schweizer Casinos mit dem besten Aviator.','img'=>'Aviator casino game Switzerland German airplane multiplier Swiss luxury'],
['slug'=>'paysafecard','h1'=>'Casino Paysafecard Schweiz — Anonym Bezahlen im Casino','meta'=>'Online Casino mit Paysafecard in der Schweiz. Anonym einzahlen mit Prepaid-Karte. Keine Bankdaten erforderlich. Casino Paysafecard Schweiz.','angle'=>'Paysafecard bietet Schweizer Spielern Anonymität beim Einzahlen. Leitfaden für Casinos mit Paysafecard in der Schweiz, wie es funktioniert, Limits, wann Paysafecard die beste Option ist.','img'=>'Paysafecard casino Switzerland German anonymous prepaid Swiss secure'],
['slug'=>'postfinance','h1'=>'Casino PostFinance Schweiz — Einzahlen per Schweizer Postbank','meta'=>'Online Casino mit PostFinance Zahlung in der Schweiz. Schweizer Bankkonto direkt nutzen. Einzahlung und Auszahlung per PostFinance.','angle'=>'PostFinance ist einzigartig für die Schweiz. Leitfaden für Casinos die PostFinance akzeptieren, wie man es für Casino-Ein- und Auszahlungen nutzt, warum es für Schweizer Spieler praktisch ist.','img'=>'PostFinance casino Switzerland German Swiss post bank payment CHF'],
['slug'=>'test','h1'=>'Online Casino Test Schweiz — Unabhängige Bewertung der Top-Casinos','meta'=>'Unabhängige Casino-Tests für die Schweiz. Unser Team testet jedes Casino für Schweizer Spieler. Bewertungen und Empfehlungen auf Deutsch.','angle'=>'Schweizer Spieler verlangen zuverlässige Bewertungen. Leitfaden für unsere Casino-Tests in der Schweiz: Methodik, Bewertungskriterien, und Testergebnisse für Schweizer Spieler.','img'=>'Casino test Switzerland German independent review expert rating'],
['slug'=>'sicherheit','h1'=>'Sicheres Online Casino Schweiz — 100% Geschützte Plattformen','meta'=>'Sichere Online Casinos in der Schweiz. CFMJ-Lizenz, SSL, Datenschutz. Sicher spielen aus der Schweiz. Sicherheitsleitfaden für Schweizer Casinos.','angle'=>'Schweizer legen großen Wert auf Sicherheit. Casino-Sicherheitsleitfaden Schweiz: CFMJ-Lizenz verstehen, SSL überprüfen, DSGVO-Schutz, betrügerische Casinos erkennen.','img'=>'Safe casino Switzerland German security protection Swiss flag lock'],
['slug'=>'anmeldung','h1'=>'Casino Anmeldung Schweiz — Schritt für Schritt Registrierung','meta'=>'Wie man sich bei einem Online Casino in der Schweiz anmeldet. Einfache Schritte, erforderliche Dokumente. Anmeldung für Schweizer Spieler.','angle'=>'Vollständiger Anmeldungsleitfaden für ein Schweizer Casino. Schritte, erforderliche Schweizer Ausweisdokumente, Altersverifizierung, und wie man seinen Bonus bei der Anmeldung aktiviert.','img'=>'Casino registration Switzerland German sign up easy Swiss guide'],
['slug'=>'verantwortungsvolles-spiel','h1'=>'Verantwortungsvolles Spielen Casino Schweiz — Sicher Spielen','meta'=>'Verantwortungsvolles Spielen in Schweizer Online Casinos. Limits, Selbstausschluss, Ressourcen. Suchtberatung und Schutztools für Schweizer Spieler.','angle'=>'Die Schweiz nimmt verantwortungsvolles Spielen sehr ernst mit Addiction Suisse. Leitfaden zum verantwortungsvollen Spielen: verfügbare Tools, nationale Selbstausschluss, Unterstressungsressourcen auf DE und FR.','img'=>'Responsible gambling Switzerland German balance protection support Swiss'],
['slug'=>'ohne-limit','h1'=>'Casino Ohne Limits Schweiz — Unbegrenzte Gewinne Auszahlen','meta'=>'Online Casinos ohne Auszahlungslimits in der Schweiz. Große Gewinne unbegrenzt auszahlen. Crypto Casinos ohne Limits für Schweizer Spieler.','angle'=>'Für Schweizer Großspieler sind Auszahlungslimits ein Problem. Leitfaden für Casinos ohne oder mit sehr hohen Limits, wie Krypto alle Limits umgeht, und welche Casinos für große Auszahlungen geeignet sind.','img'=>'No limit casino Switzerland German unlimited withdrawal big win Swiss'],
['slug'=>'turnier','h1'=>'Casino Turnier Schweiz — Wettbewerbe mit Echten Preisen in CHF','meta'=>'Casino Turniere online Schweiz. Slots und Blackjack Wettbewerbe mit Preispools. Leaderboards für Schweizer. Casino Turnier Schweiz Leitfaden.','angle'=>'Turniere casino sprechen wettbewerbsorientierte Schweizer Spieler an. Leitfaden für verfügbare Turniere in der Schweiz, wie man sich gut platziert, Preise in CHF, Strategien zur Maximierung.','img'=>'Casino tournament Switzerland German competition prizes CHF trophy'],
];

echo "🎁 DE BONUS PAGES (".count($DE_BONUS).")\n\n";

foreach ($DE_BONUS as $page) {
    $pc++;
    $dir = $BASE.'/de/bonus/'.$page['slug'];
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    echo "[".$pc."] ".$page['h1']."\n";

    $imgPath = genImg($page['img'], $page['slug'].'-de.png', $OPENAI_KEY, $IMG_DIR.'/de');

    $intro = claude("2 prägnante Werbetextsätze für Schweizer Spieler: \"".$page['h1']."\"\nFokus: ".$page['angle']."\nErwähne Schweiz, CHF. NUR 2 Sätze. Auf Deutsch.", $ANTHROPIC_KEY, 150);

    $body = claude("Schweizer Casino-Experte. Einzigartiger Artikel auf Deutsch: \"".$page['h1']."\"\nFokus: ".$page['angle']."\nKontext: CHF, CFMJ, Schweizer Premium-Spieler.\n4 Abschnitte <h2>, 700-900 Wörter, CHF-Beispiele. Verkaufsstark und ehrlich. Kein Jahr. Nur HTML.", $ANTHROPIC_KEY, 1500);

    $faqData = [
        "Ist dieser Bonus für Schweizer Spieler verfügbar?" => claude("2 Sätze: \"Ist dieser Bonus für Schweizer Spieler verfügbar?\" Kontext: ".$page['h1'].". Ehrlich. Auf Deutsch.", $ANTHROPIC_KEY, 100),
        "Können Gewinne in CHF ausgezahlt werden?" => claude("2 Sätze über CHF-Auszahlungen für Schweizer Spieler. Praktisch. Auf Deutsch.", $ANTHROPIC_KEY, 100),
        "Hat dieses Casino eine CFMJ-Lizenz?" => claude("2 Sätze über CFMJ-Lizenz und Sicherheit für Schweizer Spieler. Auf Deutsch.", $ANTHROPIC_KEY, 100),
    ];

    $relHtml = '';
    foreach (array_slice($DE_BONUS, 0, 6) as $rp) {
        if ($rp['slug'] === $page['slug']) continue;
        $relHtml .= '<a href="/de/bonus/'.$rp['slug'].'/" class="rel-card">'.htmlspecialchars($rp['h1']).'<div class="rel-sub">Casino Bonus Schweiz 🇨🇭</div></a>';
        if (substr_count($relHtml,'rel-card') >= 4) break;
    }

    $breadcrumb = '<a href="/de/">Start</a><span>›</span><a href="/de/bonus/">Bonus</a><span>›</span><span>'.htmlspecialchars($page['slug']).'</span>';
    $html = buildPage($page['h1'],$page['meta'],$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_DE,$BNAV_DE,$FOOTER_DE,'de');
    file_put_contents($dir.'/index.html', $html);
    $allPages[] = 'de/bonus/'.$page['slug'].'/';
    echo "  ✅\n";
    sleep(1);
}

// ============ CASINO + JEUX + VILLES + GUIDES + HOMEPAGES ============

$FR_CASINOS = [
    ['slug'=>'1','name'=>'Casino Alpha Suisse','bonus'=>'200% jusqu\'à 1000 CHF + 100 FS','rating'=>'4.8','badge'=>'#1 Suisse'],
    ['slug'=>'2','name'=>'SwissPlay Casino','bonus'=>'150% + 50 Free Spins','rating'=>'4.7','badge'=>'Populaire'],
    ['slug'=>'3','name'=>'Helvetia Casino','bonus'=>'100% + 200 Free Spins','rating'=>'4.6','badge'=>'Top Bonus'],
    ['slug'=>'4','name'=>'Casino Alpes','bonus'=>'200 CHF sans dépôt','rating'=>'4.5','badge'=>'Sans dépôt'],
    ['slug'=>'5','name'=>'Suisse Royale Casino','bonus'=>'300% jusqu\'à 500 CHF','rating'=>'4.5','badge'=>'Nouveau'],
    ['slug'=>'6','name'=>'Casino Geneva','bonus'=>'100 Free Spins gratuits','rating'=>'4.4','badge'=>'Free Spins'],
    ['slug'=>'7','name'=>'Lausanne Casino Online','bonus'=>'150% + cashback 15%','rating'=>'4.4','badge'=>'Cashback'],
    ['slug'=>'8','name'=>'Bern Casino Digital','bonus'=>'200% VIP exclusif','rating'=>'4.3','badge'=>'VIP'],
    ['slug'=>'9','name'=>'Casino Zurich FR','bonus'=>'100% + 50 CHF offerts','rating'=>'4.3','badge'=>'Fiable'],
    ['slug'=>'10','name'=>'Swiss Palace Casino','bonus'=>'Bitcoin +20% bonus','rating'=>'4.2','badge'=>'Crypto'],
    ['slug'=>'11','name'=>'Neuchatel Online','bonus'=>'75 free spins sans dépôt','rating'=>'4.2','badge'=>'Sans dépôt'],
    ['slug'=>'12','name'=>'Casino Vaud','bonus'=>'200% premier dépôt','rating'=>'4.1','badge'=>'Recommandé'],
    ['slug'=>'13','name'=>'Fribourg Casino','bonus'=>'100 CHF cadeau bienvenue','rating'=>'4.1','badge'=>'Bienvenue'],
    ['slug'=>'14','name'=>'Casino Valais','bonus'=>'Cashback 20% hebdo','rating'=>'4.0','badge'=>'Cashback'],
    ['slug'=>'15','name'=>'Swiss Live Casino','bonus'=>'Tables VIP exclusives','rating'=>'4.0','badge'=>'Live'],
];

$DE_CASINOS = [
    ['slug'=>'1','name'=>'Casino Alpha Schweiz','bonus'=>'200% bis 1000 CHF + 100 FS','rating'=>'4.8','badge'=>'#1 Schweiz'],
    ['slug'=>'2','name'=>'SwissPlay Casino DE','bonus'=>'150% + 50 Freispiele','rating'=>'4.7','badge'=>'Beliebt'],
    ['slug'=>'3','name'=>'Helvetia Casino DE','bonus'=>'100% + 200 Freispiele','rating'=>'4.6','badge'=>'Top Bonus'],
    ['slug'=>'4','name'=>'Casino Alpen','bonus'=>'200 CHF ohne Einzahlung','rating'=>'4.5','badge'=>'Ohne Einzahlung'],
    ['slug'=>'5','name'=>'Schweizer Royale','bonus'=>'300% bis 500 CHF','rating'=>'4.5','badge'=>'Neu'],
    ['slug'=>'6','name'=>'Genf Casino Online','bonus'=>'100 Freispiele gratis','rating'=>'4.4','badge'=>'Freispiele'],
    ['slug'=>'7','name'=>'Lausanne Casino DE','bonus'=>'150% + 15% Cashback','rating'=>'4.4','badge'=>'Cashback'],
    ['slug'=>'8','name'=>'Bern Online Casino','bonus'=>'200% VIP exklusiv','rating'=>'4.3','badge'=>'VIP'],
    ['slug'=>'9','name'=>'Zürich Casino Online','bonus'=>'100% + 50 CHF Geschenk','rating'=>'4.3','badge'=>'Vertrauenswürdig'],
    ['slug'=>'10','name'=>'Swiss Palace DE','bonus'=>'Bitcoin +20% Bonus','rating'=>'4.2','badge'=>'Krypto'],
    ['slug'=>'11','name'=>'Neuenburg Casino','bonus'=>'75 Freispiele ohne Einzahlung','rating'=>'4.2','badge'=>'Ohne Einzahlung'],
    ['slug'=>'12','name'=>'Waadt Casino','bonus'=>'200% erste Einzahlung','rating'=>'4.1','badge'=>'Empfohlen'],
    ['slug'=>'13','name'=>'Freiburg Casino DE','bonus'=>'100 CHF Willkommensgeschenk','rating'=>'4.1','badge'=>'Willkommen'],
    ['slug'=>'14','name'=>'Wallis Casino','bonus'=>'20% wöchentlicher Cashback','rating'=>'4.0','badge'=>'Cashback'],
    ['slug'=>'15','name'=>'Swiss Live Casino DE','bonus'=>'Exklusive VIP-Tische','rating'=>'4.0','badge'=>'Live'],
];

// CASINO PAGES FR
echo "🎰 FR CASINO PAGES\n\n";
foreach ($FR_CASINOS as $c) {
    $pc++;
    $slug = 'casino-suisse-'.$c['slug'];
    $dir = $BASE.'/fr/casino/'.$slug;
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    echo "[".$pc."] ".$c['name']."\n";
    $imgPath = genImg($c['name'].' Switzerland casino luxury premium dark red gold', $slug.'.png', $OPENAI_KEY, $IMG_DIR.'/fr');
    $h1 = $c['name'].' — Avis Casino Suisse '.$c['badge'];
    $intro = claude("2 phrases d'accroche pour: \"".$h1."\". Bonus: ".$c['bonus'].". Pour joueurs suisses. SEULEMENT 2 phrases.", $ANTHROPIC_KEY, 150);
    $body = claude("Avis complet sur casino suisse: \"".$c['name']."\". Bonus: ".$c['bonus'].". Note: ".$c['rating']."/5.\nSections: Présentation, Bonus, Jeux, Paiements CHF, Verdict. 600-800 mots. Expert. Pas d'année. HTML.", $ANTHROPIC_KEY, 1200);
    $faqData = [$c['name']." est-il légal en Suisse?" => "Oui, ce casino possède les autorisations nécessaires pour les joueurs suisses. Vérifiez toujours la licence avant de jouer.", "Comment retirer mes gains en CHF?" => "Les retraits en CHF sont disponibles via virement, TWINT et cartes. Délais: quelques heures à 48h.", "Le bonus de ".$c['bonus']." est-il vraiment disponible?" => "Oui, ce bonus est disponible pour les nouveaux joueurs résidant en Suisse. Des conditions de mise s'appliquent."];
    $relHtml = '';
    foreach (array_slice($FR_CASINOS,0,5) as $rc) {
        if($rc['slug']===$c['slug']) continue;
        $relHtml .= '<a href="/fr/casino/casino-suisse-'.$rc['slug'].'/" class="rel-card">'.$rc['name'].'<div class="rel-sub">'.$rc['badge'].' · '.$rc['rating'].'/5</div></a>';
        if(substr_count($relHtml,'rel-card')>=4) break;
    }
    $breadcrumb = '<a href="/fr/">Accueil</a><span>›</span><a href="/fr/casino/">Casinos</a><span>›</span><span>'.$c['name'].'</span>';
    $html = buildPage($h1,'Avis '.$c['name'].' — '.$c['bonus'].'. Note '.$c['rating'].'/5.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_FR,$BNAV_FR,$FOOTER_FR,'fr');
    file_put_contents($dir.'/index.html',$html);
    $allPages[] = 'fr/casino/'.$slug.'/';
    echo "  ✅\n"; sleep(1);
}

// CASINO PAGES DE
echo "🎰 DE CASINO PAGES\n\n";
foreach ($DE_CASINOS as $c) {
    $pc++;
    $slug = 'casino-schweiz-'.$c['slug'];
    $dir = $BASE.'/de/casino/'.$slug;
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    echo "[".$pc."] ".$c['name']."\n";
    $imgPath = genImg($c['name'].' Schweiz casino luxury premium dark red gold German', $slug.'.png', $OPENAI_KEY, $IMG_DIR.'/de');
    $h1 = $c['name'].' — Bewertung Casino Schweiz '.$c['badge'];
    $intro = claude("2 werbewirksame Sätze für: \"".$h1."\". Bonus: ".$c['bonus'].". Für Schweizer. NUR 2 Sätze. Auf Deutsch.", $ANTHROPIC_KEY, 150);
    $body = claude("Vollständige deutsche Casino-Bewertung: \"".$c['name']."\". Bonus: ".$c['bonus'].". Bewertung: ".$c['rating']."/5.\nAbschnitte: Vorstellung, Boni, Spielangebot, CHF-Zahlungen, Fazit. 600-800 Wörter. Kein Jahr. HTML.", $ANTHROPIC_KEY, 1200);
    $faqData = ["Ist ".$c['name']." in der Schweiz legal?" => "Ja, dieses Casino hat die erforderlichen Genehmigungen für Schweizer Spieler. Überprüfen Sie immer die Lizenz.", "Wie kann ich in CHF auszahlen?" => "CHF-Auszahlungen sind per Banküberweisung, TWINT und Kreditkarten verfügbar. Bearbeitungszeiten: wenige Stunden bis 48h.", "Ist der Bonus von ".$c['bonus']." verfügbar?" => "Ja, dieser Bonus steht neuen Spielern in der Schweiz zur Verfügung. Umsatzbedingungen gelten."];
    $relHtml = '';
    foreach (array_slice($DE_CASINOS,0,5) as $rc) {
        if($rc['slug']===$c['slug']) continue;
        $relHtml .= '<a href="/de/casino/casino-schweiz-'.$rc['slug'].'/" class="rel-card">'.$rc['name'].'<div class="rel-sub">'.$rc['badge'].' · '.$rc['rating'].'/5</div></a>';
        if(substr_count($relHtml,'rel-card')>=4) break;
    }
    $breadcrumb = '<a href="/de/">Start</a><span>›</span><a href="/de/casino/">Casinos</a><span>›</span><span>'.$c['name'].'</span>';
    $html = buildPage($h1,'Bewertung '.$c['name'].' — '.$c['bonus'].'. Bewertung '.$c['rating'].'/5.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_DE,$BNAV_DE,$FOOTER_DE,'de');
    file_put_contents($dir.'/index.html',$html);
    $allPages[] = 'de/casino/'.$slug.'/';
    echo "  ✅\n"; sleep(1);
}

// ============ JEUX FR + SPIELE DE (15+15) ============
$JEUX = [
['fr_slug'=>'aviator','fr_h1'=>'Aviator Casino Suisse — Stratégie et Meilleurs Sites','de_slug'=>'aviator','de_h1'=>'Aviator Casino Schweiz — Strategie und Beste Seiten','img'=>'Aviator crash game Switzerland airplane multiplier dark luxury'],
['fr_slug'=>'gates-olympus','fr_h1'=>'Gates of Olympus Suisse — Guide Complet et Bonus','de_slug'=>'gates-olympus','de_h1'=>'Gates of Olympus Schweiz — Vollständiger Leitfaden','img'=>'Gates of Olympus slot Switzerland Zeus golden luxury reels'],
['fr_slug'=>'blackjack','fr_h1'=>'Blackjack en Ligne Suisse — Stratégie de Base Gagnante','de_slug'=>'blackjack','de_h1'=>'Blackjack Online Schweiz — Grundstrategie zum Gewinnen','img'=>'Blackjack casino Switzerland cards chips elegant luxury dark'],
['fr_slug'=>'roulette','fr_h1'=>'Roulette en Ligne Suisse — Européenne vs Américaine','de_slug'=>'roulette','de_h1'=>'Roulette Online Schweiz — Europäisch vs Amerikanisch','img'=>'Roulette casino Switzerland European wheel elegant luxury'],
['fr_slug'=>'baccarat','fr_h1'=>'Baccarat Casino Suisse — Règles et Stratégie Complètes','de_slug'=>'baccarat','de_h1'=>'Baccarat Casino Schweiz — Vollständige Regeln und Strategie','img'=>'Baccarat casino Switzerland luxury table cards elegant'],
['fr_slug'=>'sweet-bonanza','fr_h1'=>'Sweet Bonanza Casino Suisse — Bonus et Multiplicateurs','de_slug'=>'sweet-bonanza','de_h1'=>'Sweet Bonanza Casino Schweiz — Bonus und Multiplikatoren','img'=>'Sweet Bonanza slot Switzerland candy colorful luxury'],
['fr_slug'=>'slots','fr_h1'=>'Machines à Sous Casino Suisse — Top 50 Slots en CHF','de_slug'=>'spielautomaten','de_h1'=>'Spielautomaten Casino Schweiz — Top 50 Slots in CHF','img'=>'Slot machines casino Switzerland luxury golden premium'],
['fr_slug'=>'casino-live','fr_h1'=>'Casino Live Suisse — Vrais Croupiers en Direct','de_slug'=>'live-casino','de_h1'=>'Live Casino Schweiz — Echte Dealer in Echtzeit','img'=>'Live casino Switzerland dealer stream luxury elegant'],
['fr_slug'=>'poker','fr_h1'=>'Poker Casino Suisse — Video Poker et Casino Holdem','de_slug'=>'poker','de_h1'=>'Poker Casino Schweiz — Video Poker und Casino Holdem','img'=>'Poker casino Switzerland cards chips luxury dark'],
['fr_slug'=>'jackpots','fr_h1'=>'Jackpots Progressifs Casino Suisse — Gagnez des Millions','de_slug'=>'jackpots','de_h1'=>'Progressive Jackpots Casino Schweiz — Millionen Gewinnen','img'=>'Progressive jackpot casino Switzerland millions CHF luxury'],
['fr_slug'=>'mahjong-ways','fr_h1'=>'Mahjong Ways Casino Suisse — Guide et Stratégie','de_slug'=>'mahjong-ways','de_h1'=>'Mahjong Ways Casino Schweiz — Leitfaden und Strategie','img'=>'Mahjong Ways slot Switzerland Asian golden luxury'],
['fr_slug'=>'book-of-dead','fr_h1'=>'Book of Dead Casino Suisse — Stratégie Gagnante','de_slug'=>'book-of-dead','de_h1'=>'Book of Dead Casino Schweiz — Gewinnstrategie','img'=>'Book of Dead slot Switzerland Egypt golden luxury'],
['fr_slug'=>'dragon-tiger','fr_h1'=>'Dragon Tiger Casino Suisse — Le Jeu le Plus Simple','de_slug'=>'dragon-tiger','de_h1'=>'Dragon Tiger Casino Schweiz — Das Einfachste Spiel','img'=>'Dragon Tiger casino Switzerland Asian simple elegant'],
['fr_slug'=>'spaceman','fr_h1'=>'Spaceman Casino Suisse — Alternative à Aviator','de_slug'=>'spaceman','de_h1'=>'Spaceman Casino Schweiz — Alternative zu Aviator','img'=>'Spaceman crash game Switzerland space luxury dark'],
['fr_slug'=>'plinko','fr_h1'=>'Plinko Casino Suisse — Guide et Stratégie de Risque','de_slug'=>'plinko','de_h1'=>'Plinko Casino Schweiz — Leitfaden und Risikostrategie','img'=>'Plinko casino game Switzerland risk board luxury'],
];

echo "🎮 JEUX/SPIELE PAGES\n\n";
foreach ($JEUX as $j) {
    // FR
    $pc++;
    $dir = $BASE.'/fr/jeux/'.$j['fr_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] FR: ".$j['fr_h1']."\n";
    $imgPath = genImg($j['img'],$j['fr_slug'].'.png',$OPENAI_KEY,$IMG_DIR.'/fr');
    $intro = claude("2 phrases d'accroche pour joueurs suisses: \"".$j['fr_h1']."\". CHF, Suisse. SEULEMENT 2 phrases.",$ANTHROPIC_KEY,150);
    $body = claude("Guide casino suisse: \"".$j['fr_h1']."\"\n3 sections <h2>: règles/fonctionnement, stratégie, bonus disponibles en Suisse. 500-700 mots. CHF. Pas d'année. HTML.",$ANTHROPIC_KEY,1000);
    $faqData = ["Ce jeu est-il disponible en Suisse?"=>"Oui, ce jeu est disponible dans les meilleurs casinos suisses avec les meilleures conditions en CHF.","Peut-on jouer gratuitement en Suisse?"=>"Oui, la version démo est disponible depuis la Suisse. Testez avant de jouer avec de l'argent réel.","Quel bonus pour jouer en Suisse?"=>"Plusieurs casinos offrent des bonus spéciaux pour ce jeu en Suisse. Profitez des free spins et bonus bienvenue."];
    $relHtml=''; foreach(array_slice($JEUX,0,5) as $rj){if($rj['fr_slug']===$j['fr_slug'])continue; $relHtml.='<a href="/fr/jeux/'.$rj['fr_slug'].'/" class="rel-card">'.$rj['fr_h1'].'<div class="rel-sub">Jeu Casino Suisse 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/fr/">Accueil</a><span>›</span><a href="/fr/jeux/">Jeux</a><span>›</span><span>'.$j['fr_slug'].'</span>';
    $html=buildPage($j['fr_h1'],'Guide '.$j['fr_h1'].' pour joueurs suisses. Stratégies, bonus, meilleures plateformes en CHF.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_FR,$BNAV_FR,$FOOTER_FR,'fr');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='fr/jeux/'.$j['fr_slug'].'/';
    echo "  ✅\n"; sleep(1);

    // DE
    $pc++;
    $dir = $BASE.'/de/spiele/'.$j['de_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] DE: ".$j['de_h1']."\n";
    $intro = claude("2 werbewirksame Sätze für Schweizer: \"".$j['de_h1']."\". CHF, Schweiz. NUR 2 Sätze. Auf Deutsch.",$ANTHROPIC_KEY,150);
    $body = claude("Schweizer Casino Leitfaden auf Deutsch: \"".$j['de_h1']."\"\n3 Abschnitte <h2>: Regeln, Strategie, verfügbare Boni in der Schweiz. 500-700 Wörter. CHF. Kein Jahr. Nur HTML.",$ANTHROPIC_KEY,1000);
    $faqData = ["Ist dieses Spiel in der Schweiz verfügbar?"=>"Ja, dieses Spiel ist in den besten Schweizer Casinos unter optimalen Bedingungen in CHF verfügbar.","Kann man in der Schweiz kostenlos spielen?"=>"Ja, die Demo-Version ist aus der Schweiz verfügbar. Testen Sie, bevor Sie mit echtem Geld spielen.","Welcher Bonus für dieses Spiel in der Schweiz?"=>"Mehrere Casinos bieten spezielle Boni für dieses Spiel in der Schweiz. Nutzen Sie Freispiele und Willkommensboni."];
    $relHtml=''; foreach(array_slice($JEUX,0,5) as $rj){if($rj['de_slug']===$j['de_slug'])continue; $relHtml.='<a href="/de/spiele/'.$rj['de_slug'].'/" class="rel-card">'.$rj['de_h1'].'<div class="rel-sub">Casino Spiel Schweiz 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/de/">Start</a><span>›</span><a href="/de/spiele/">Spiele</a><span>›</span><span>'.$j['de_slug'].'</span>';
    $html=buildPage($j['de_h1'],'Leitfaden '.$j['de_h1'].' für Schweizer Spieler. Strategien, Boni, beste Plattformen in CHF.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_DE,$BNAV_DE,$FOOTER_DE,'de');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='de/spiele/'.$j['de_slug'].'/';
    echo "  ✅\n"; sleep(1);
}

// ============ VILLES FR + STAEDTE DE (10+10) ============
$VILLES = [
['fr_slug'=>'geneve','fr_h1'=>'Casino en Ligne Genève — Meilleures Offres pour Genevois','de_slug'=>'genf','de_h1'=>'Online Casino Genf — Beste Angebote für Genfer Spieler','img'=>'Geneva casino Switzerland Lake Leman luxury French international'],
['fr_slug'=>'lausanne','fr_h1'=>'Casino en Ligne Lausanne — Guide Casino Vaud et Romandie','de_slug'=>'lausanne','de_h1'=>'Online Casino Lausanne — Leitfaden Waadt und Romandie','img'=>'Lausanne casino Switzerland Vaud lake Olympic city luxury'],
['fr_slug'=>'zurich-fr','fr_h1'=>'Casino en Ligne Zurich — Guide Bilingue FR/DE pour Zurichois','de_slug'=>'zuerich','de_h1'=>'Online Casino Zürich — Beste Casinos für Zürcher Spieler','img'=>'Zurich casino Switzerland economic capital luxury skyline'],
['fr_slug'=>'berne','fr_h1'=>'Casino en Ligne Berne — Guide Casino depuis la Capitale','de_slug'=>'bern','de_h1'=>'Online Casino Bern — Leitfaden für die Bundeshauptstadt','img'=>'Bern casino Switzerland capital arcades bear luxury'],
['fr_slug'=>'bale','fr_h1'=>'Casino en Ligne Bâle — Guide Tripoint CH/DE/FR','de_slug'=>'basel','de_h1'=>'Online Casino Basel — Leitfaden am Dreiländereck','img'=>'Basel casino Switzerland tripoint border luxury Rhine'],
['fr_slug'=>'fribourg','fr_h1'=>'Casino en Ligne Fribourg — Guide Ville Bilingue Suisse','de_slug'=>'freiburg','de_h1'=>'Online Casino Freiburg — Zweisprachige Schweizer Stadt','img'=>'Fribourg casino Switzerland bilingual city medieval luxury'],
['fr_slug'=>'neuchatel','fr_h1'=>'Casino en Ligne Neuchâtel — Guide Casino Lac de Neuchâtel','de_slug'=>'neuenburg','de_h1'=>'Online Casino Neuenburg — Leitfaden Neuenburger See','img'=>'Neuchatel casino Switzerland lake watchmaking luxury'],
['fr_slug'=>'sion','fr_h1'=>'Casino en Ligne Sion — Guide Casino Valais Alpin','de_slug'=>'sitten','de_h1'=>'Online Casino Sitten — Wallis Casino Leitfaden','img'=>'Sion Valais casino Switzerland Alps mountains luxury'],
['fr_slug'=>'lucerne','fr_h1'=>'Casino en Ligne Lucerne — Jouer au Cœur de la Suisse','de_slug'=>'luzern','de_h1'=>'Online Casino Luzern — Im Herzen der Schweiz Spielen','img'=>'Lucerne casino Switzerland lake chapel bridge luxury'],
['fr_slug'=>'lugano','fr_h1'=>'Casino en Ligne Lugano — Casino Tessin Italophone','de_slug'=>'lugano','de_h1'=>'Online Casino Lugano — Tessin Leitfaden auf Deutsch','img'=>'Lugano casino Switzerland Italian Ticino luxury lake palm'],
];

echo "🏙️ VILLES/STAEDTE PAGES\n\n";
foreach ($VILLES as $v) {
    // FR
    $pc++;
    $dir=$BASE.'/fr/villes/'.$v['fr_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] FR: ".$v['fr_h1']."\n";
    $imgPath=genImg($v['img'],$v['fr_slug'].'.png',$OPENAI_KEY,$IMG_DIR.'/fr');
    $intro=claude("2 phrases pour joueurs de cette ville suisse: \"".$v['fr_h1']."\". Local et vendeur. SEULEMENT 2 phrases.",$ANTHROPIC_KEY,150);
    $body=claude("Guide casino en ligne: \"".$v['fr_h1']."\"\n3 sections <h2>: contexte local casino, meilleures offres, méthodes de paiement locales. 500-700 mots. CHF. Pas d'année. HTML.",$ANTHROPIC_KEY,1000);
    $faqData=["Les casinos en ligne sont-ils légaux depuis cette ville?"=>"Oui, les casinos en ligne légaux sont accessibles depuis toute la Suisse, y compris depuis cette ville.","Quelle méthode de paiement recommandez-vous?"=>"TWINT est la méthode la plus pratique. Les virements bancaires CHF et la crypto sont également disponibles.","Y a-t-il des bonus exclusifs pour les joueurs locaux?"=>"Oui, plusieurs casinos offrent des bonus spéciaux pour les résidents suisses. Profitez des offres disponibles."];
    $relHtml=''; foreach(array_slice($VILLES,0,5) as $rv){if($rv['fr_slug']===$v['fr_slug'])continue; $relHtml.='<a href="/fr/villes/'.$rv['fr_slug'].'/" class="rel-card">'.$rv['fr_h1'].'<div class="rel-sub">Casino Suisse 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/fr/">Accueil</a><span>›</span><a href="/fr/villes/">Villes</a><span>›</span><span>'.explode(' —',$v['fr_h1'])[0].'</span>';
    $html=buildPage($v['fr_h1'],'Casino en ligne depuis '.explode('—',$v['fr_h1'])[0].'. Guide local, bonus CHF, méthodes de paiement.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_FR,$BNAV_FR,$FOOTER_FR,'fr');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='fr/villes/'.$v['fr_slug'].'/';
    echo "  ✅\n"; sleep(1);

    // DE
    $pc++;
    $dir=$BASE.'/de/staedte/'.$v['de_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] DE: ".$v['de_h1']."\n";
    $intro=claude("2 Sätze für Spieler aus dieser Schweizer Stadt: \"".$v['de_h1']."\". Lokal. NUR 2 Sätze. Auf Deutsch.",$ANTHROPIC_KEY,150);
    $body=claude("Casino Leitfaden auf Deutsch: \"".$v['de_h1']."\"\n3 Abschnitte <h2>: lokaler Kontext, beste Angebote, Zahlungsmethoden. 500-700 Wörter. CHF. Kein Jahr. HTML.",$ANTHROPIC_KEY,1000);
    $faqData=["Sind Online-Casinos aus dieser Stadt legal?"=>"Ja, legale Online-Casinos sind aus der gesamten Schweiz zugänglich. Wählen Sie CFMJ-lizenzierte Plattformen.","Welche Zahlungsmethode empfehlen Sie?"=>"TWINT ist die praktischste Methode. CHF-Banküberweisungen und Krypto sind ebenfalls verfügbar.","Gibt es exklusive Boni für lokale Spieler?"=>"Ja, mehrere Casinos bieten spezielle Boni für Schweizer Spieler. Nutzen Sie die verfügbaren Angebote."];
    $relHtml=''; foreach(array_slice($VILLES,0,5) as $rv){if($rv['de_slug']===$v['de_slug'])continue; $relHtml.='<a href="/de/staedte/'.$rv['de_slug'].'/" class="rel-card">'.$rv['de_h1'].'<div class="rel-sub">Casino Schweiz 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/de/">Start</a><span>›</span><a href="/de/staedte/">Städte</a><span>›</span><span>'.explode(' —',$v['de_h1'])[0].'</span>';
    $html=buildPage($v['de_h1'],'Online Casino aus '.explode('—',$v['de_h1'])[0].'. Leitfaden, CHF-Boni, lokale Zahlungsmethoden.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_DE,$BNAV_DE,$FOOTER_DE,'de');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='de/staedte/'.$v['de_slug'].'/';
    echo "  ✅\n"; sleep(1);
}

// ============ GUIDES FR + DE (10+10) ============
$GUIDES = [
['fr_slug'=>'commencer','fr_h1'=>'Comment Commencer au Casino en Ligne en Suisse','de_slug'=>'anfaenger','de_h1'=>'Wie man in der Schweiz im Online Casino anfängt','img'=>'Casino beginner Switzerland start guide luxury Swiss dark'],
['fr_slug'=>'deposer','fr_h1'=>'Comment Déposer au Casino en Suisse — Guide Complet','de_slug'=>'einzahlen','de_h1'=>'Wie man im Schweizer Casino einzahlt — Vollständiger Leitfaden','img'=>'Casino deposit Switzerland guide CHF payment luxury'],
['fr_slug'=>'retirer','fr_h1'=>'Retrait Casino Suisse — Récupérer ses Gains en CHF','de_slug'=>'auszahlen','de_h1'=>'Casino Auszahlung Schweiz — Gewinne in CHF Abheben','img'=>'Casino withdrawal Switzerland CHF fast guide luxury'],
['fr_slug'=>'bonus-guide','fr_h1'=>'Guide des Bonus Casino Suisse — Tout Comprendre','de_slug'=>'bonus-leitfaden','de_h1'=>'Casino Bonus Leitfaden Schweiz — Alles Verstehen','img'=>'Casino bonus guide Switzerland understand complete Swiss'],
['fr_slug'=>'securite','fr_h1'=>'Sécurité Casino Suisse — Jouer en Toute Sécurité','de_slug'=>'sicherheit','de_h1'=>'Casino Sicherheit Schweiz — Sicher Spielen','img'=>'Casino security Switzerland safe protection Swiss'],
['fr_slug'=>'legal','fr_h1'=>'Légalité Casino en Ligne Suisse — CFMJ Expliqué','de_slug'=>'legalitaet','de_h1'=>'Legalität Online Casino Schweiz — CFMJ Erklärt','img'=>'Casino legal Switzerland CFMJ regulation official Swiss'],
['fr_slug'=>'strategie','fr_h1'=>'Stratégie Casino Suisse — Maximiser ses Chances de Gain','de_slug'=>'strategie','de_h1'=>'Casino Strategie Schweiz — Chancen Maximieren','img'=>'Casino strategy Switzerland maximize chances smart Swiss'],
['fr_slug'=>'jeu-responsable','fr_h1'=>'Jeu Responsable en Suisse — Jouer Sans Tomber dans l\'Addiction','de_slug'=>'verantwortungsvoll','de_h1'=>'Verantwortungsvolles Spielen Schweiz — Ohne Sucht Spielen','img'=>'Responsible gambling Switzerland balance protection support'],
['fr_slug'=>'mobile','fr_h1'=>'Casino Mobile Suisse — Jouer sur Smartphone en Suisse','de_slug'=>'mobil','de_h1'=>'Mobiles Casino Schweiz — Auf dem Smartphone Spielen','img'=>'Mobile casino Switzerland smartphone play Swiss luxury'],
['fr_slug'=>'wagering','fr_h1'=>'Conditions de Mise Casino Suisse — Comprendre le Wagering','de_slug'=>'umsatzbedingungen','de_h1'=>'Casino Umsatzbedingungen Schweiz — Wagering Verstehen','img'=>'Wagering requirements casino Switzerland understand CHF clear'],
];

echo "📖 GUIDE PAGES\n\n";
foreach ($GUIDES as $g) {
    // FR
    $pc++;
    $dir=$BASE.'/fr/guide/'.$g['fr_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] FR: ".$g['fr_h1']."\n";
    $imgPath=genImg($g['img'],$g['fr_slug'].'.png',$OPENAI_KEY,$IMG_DIR.'/fr');
    $intro=claude("2 phrases d'intro vendeuses pour joueurs suisses: \"".$g['fr_h1']."\". CHF, Suisse. SEULEMENT 2 phrases.",$ANTHROPIC_KEY,150);
    $body=claude("Guide pratique pour joueurs suisses: \"".$g['fr_h1']."\"\n4 sections <h2>, 600-800 mots. Exemples CHF. Pas d'année. HTML.",$ANTHROPIC_KEY,1200);
    $faqData=["Ce guide est-il valable pour tous les cantons suisses?"=>"Oui, ce guide est valable dans toute la Suisse avec quelques spécificités cantonales mineures.","Les informations sont-elles à jour?"=>"Oui, nos informations sont régulièrement mises à jour pour refléter le marché suisse actuel.","Où puis-je obtenir plus d'aide en français?"=>"Notre site propose de nombreux guides en français adaptés aux joueurs suisses. Explorez nos sections bonus et casino."];
    $relHtml=''; foreach(array_slice($GUIDES,0,5) as $rg){if($rg['fr_slug']===$g['fr_slug'])continue; $relHtml.='<a href="/fr/guide/'.$rg['fr_slug'].'/" class="rel-card">'.$rg['fr_h1'].'<div class="rel-sub">Guide Casino Suisse 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/fr/">Accueil</a><span>›</span><a href="/fr/guide/">Guides</a><span>›</span><span>'.$g['fr_slug'].'</span>';
    $html=buildPage($g['fr_h1'],$g['fr_h1'].' — Guide pratique pour joueurs suisses en CHF.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_FR,$BNAV_FR,$FOOTER_FR,'fr');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='fr/guide/'.$g['fr_slug'].'/';
    echo "  ✅\n"; sleep(1);

    // DE
    $pc++;
    $dir=$BASE.'/de/guide/'.$g['de_slug'];
    if(!is_dir($dir)) mkdir($dir,0755,true);
    echo "[".$pc."] DE: ".$g['de_h1']."\n";
    $intro=claude("2 werbewirksame Sätze für Schweizer: \"".$g['de_h1']."\". CHF, Schweiz. NUR 2 Sätze. Auf Deutsch.",$ANTHROPIC_KEY,150);
    $body=claude("Praktischer Leitfaden für Schweizer Spieler: \"".$g['de_h1']."\"\n4 Abschnitte <h2>, 600-800 Wörter. CHF-Beispiele. Kein Jahr. HTML.",$ANTHROPIC_KEY,1200);
    $faqData=["Gilt dieser Leitfaden für alle Kantone?"=>"Ja, dieser Leitfaden gilt in der gesamten Schweiz mit einigen geringfügigen kantonalen Besonderheiten.","Sind die Informationen aktuell?"=>"Ja, unsere Informationen werden regelmäßig aktualisiert, um den aktuellen Schweizer Markt widerzuspiegeln.","Wo finde ich mehr Hilfe auf Deutsch?"=>"Unsere Website bietet viele Leitfäden auf Deutsch für Schweizer Spieler. Erkunden Sie unsere Bonus- und Casino-Bereiche."];
    $relHtml=''; foreach(array_slice($GUIDES,0,5) as $rg){if($rg['de_slug']===$g['de_slug'])continue; $relHtml.='<a href="/de/guide/'.$rg['de_slug'].'/" class="rel-card">'.$rg['de_h1'].'<div class="rel-sub">Casino Leitfaden Schweiz 🇨🇭</div></a>'; if(substr_count($relHtml,'rel-card')>=4)break;}
    $breadcrumb='<a href="/de/">Start</a><span>›</span><a href="/de/guide/">Guides</a><span>›</span><span>'.$g['de_slug'].'</span>';
    $html=buildPage($g['de_h1'],$g['de_h1'].' — Praktischer Leitfaden für Schweizer Spieler in CHF.',$breadcrumb,$intro,$body,faqHtml($faqData),$relHtml,$AFF[$pc%3],$imgPath,$NAV_DE,$BNAV_DE,$FOOTER_DE,'de');
    file_put_contents($dir.'/index.html',$html);
    $allPages[]='de/guide/'.$g['de_slug'].'/';
    echo "  ✅\n"; sleep(1);
}

// ============ HOMEPAGES FR + DE ============
echo "\n🏠 HOMEPAGES\n";

$frDesc = claude("2-3 phrases d'accroche vendeuses pour homepage comparateur casinos suisses. Public: joueurs résidant en Suisse. Mentionne CHF, CFMJ, bonus. Français naturel.",$ANTHROPIC_KEY,150);
$deDesc = claude("2-3 werbewirksame Sätze für Homepage Schweizer Casino-Vergleichswebsite. Zielgruppe: Spieler in der Schweiz. Erwähne CHF, CFMJ, Boni. Natürliches Deutsch.",$ANTHROPIC_KEY,150);

// Casino cards helper
function casinoCards($casinos, $lang, $path, $pfx, $aff) {
    $html='';
    foreach(array_slice($casinos,0,6) as $c) {
        $url='/'.$path.'/casino/'.$pfx.$c['slug'].'/';
        $play=$lang==='fr'?'Jouer Maintenant →':'Jetzt Spielen →';
        $label=$lang==='fr'?'Bonus exclusif · Sponsorisé':'Exklusiver Bonus · Gesponsert';
        $html.='<a href="'.$url.'" class="casino-card"><div class="casino-badge">'.$c['badge'].'</div><div class="casino-card-header"><div class="casino-logo">🎰</div><div><div class="casino-name">'.$c['name'].'</div><div class="casino-rating"><span class="stars">★★★★★</span><span class="rating-num">'.$c['rating'].'</span></div></div></div><div class="casino-bonus"><div class="bonus-amount">'.$c['bonus'].'</div><div class="bonus-desc">'.$label.'</div></div><div class="casino-cta">'.$play.'</div></a>';
    }
    return $html;
}

// FR HOMEPAGE
$frHP = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808"><title>Meilleur Casino en Ligne Suisse — Bonus CHF & Offres Exclusives | HurrahCasino.ch</title><meta name="description" content="Meilleurs casinos en ligne pour joueurs suisses. Comparez les bonus en CHF, free spins, bonus sans dépôt. Sites légaux CFMJ. Guide casino Suisse francophone."><link rel="canonical" href="https://hurrahcasino.ch/fr/"><link rel="alternate" hreflang="fr" href="https://hurrahcasino.ch/fr/"><link rel="alternate" hreflang="de" href="https://hurrahcasino.ch/de/"><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'</style></head><body>
<div class="lang-bar"><a href="/fr/" class="lang-btn active">🇨🇭 Français</a><a href="/de/" class="lang-btn">🇩🇪 Deutsch</a></div>
'.$NAV_FR.'
<div class="swiss-divider"></div>
<section class="hero">
  <div class="hero-badge">🇨🇭 Casinos Vérifiés pour la Suisse</div>
  <h1>Meilleur Casino en Ligne<br><em>Suisse Francophone</em></h1>
  <p class="hero-desc">'.$frDesc.'</p>
  <div class="hero-btns"><a href="#casinos" class="btn-primary">🎰 Voir les Casinos</a><a href="/fr/bonus/" class="btn-secondary">🎁 Meilleurs Bonus</a></div>
</section>
<div class="stats-bar">
  <div class="stat-item"><span class="stat-num">40+</span><div class="stat-lbl">Casinos testés</div></div>
  <div class="stat-item"><span class="stat-num">CHF</span><div class="stat-lbl">Dépôts en CHF</div></div>
  <div class="stat-item"><span class="stat-num">CFMJ</span><div class="stat-lbl">Sites légaux</div></div>
  <div class="stat-item"><span class="stat-num">FR/DE</span><div class="stat-lbl">Support bilingue</div></div>
  <div class="stat-item"><span class="stat-num">24/7</span><div class="stat-lbl">Service client</div></div>
</div>
<div class="trust-strip">
  <div class="trust-badge">🔒 SSL Sécurisé</div>
  <div class="trust-badge">⚖️ Licence CFMJ</div>
  <div class="trust-badge">🏦 Paiements CHF</div>
  <div class="trust-badge">🇨🇭 Pour Résidents CH</div>
  <div class="trust-badge">⚡ Retrait Rapide</div>
  <div class="trust-badge">📱 Mobile Ready</div>
</div>
<section class="section" id="casinos">
  <div class="sec-eyebrow">Top Classement</div>
  <h2 class="sec-title">Meilleurs Casinos <span>Suisse</span></h2>
  <p style="color:var(--gray);font-size:13px;margin-bottom:16px">Sélection vérifiée. Contenu sponsorisé.</p>
  <div class="casino-grid">'.casinoCards($FR_CASINOS,'fr','fr','casino-suisse-',$AFF[0]).'</div>
</section>
<div class="cta-section">
  <div class="cta-title">🎁 <span>Bonus Exclusif Suisse</span></div>
  <div class="cta-sub">Offre sponsorisée · Jouez responsablement · Réservé aux +18 ans</div>
  <a href="'.$AFF[0].'" target="_blank" rel="noopener sponsored" class="cta-btn">Réclamer mon Bonus →</a>
  <span class="cta-sponsored">Lien sponsorisé — les jeux d\'argent peuvent créer une dépendance</span>
</div>
<section class="section">
  <div class="sec-eyebrow">Offres Populaires</div>
  <h2 class="sec-title">Bonus Casino <span>Suisse</span></h2>
  <div class="bonus-grid">
    <a href="/fr/bonus/sans-depot/" class="bonus-pill"><span class="bonus-pill-icon">🎁</span><div class="bonus-pill-name">Sans Dépôt</div><div class="bonus-pill-amount">Gratuit</div></a>
    <a href="/fr/bonus/free-spins/" class="bonus-pill"><span class="bonus-pill-icon">🎰</span><div class="bonus-pill-name">Free Spins</div><div class="bonus-pill-amount">50-500 tours</div></a>
    <a href="/fr/bonus/bienvenue/" class="bonus-pill"><span class="bonus-pill-icon">💰</span><div class="bonus-pill-name">Bienvenue</div><div class="bonus-pill-amount">100-200%</div></a>
    <a href="/fr/bonus/cashback/" class="bonus-pill"><span class="bonus-pill-icon">💳</span><div class="bonus-pill-name">Cashback</div><div class="bonus-pill-amount">10-20%</div></a>
    <a href="/fr/bonus/bitcoin/" class="bonus-pill"><span class="bonus-pill-icon">₿</span><div class="bonus-pill-name">Bitcoin</div><div class="bonus-pill-amount">+15% extra</div></a>
    <a href="/fr/bonus/twint/" class="bonus-pill"><span class="bonus-pill-icon">📱</span><div class="bonus-pill-name">TWINT</div><div class="bonus-pill-amount">Sans frais</div></a>
    <a href="/fr/bonus/legal/" class="bonus-pill"><span class="bonus-pill-icon">⚖️</span><div class="bonus-pill-name">Casino Légal</div><div class="bonus-pill-amount">CFMJ</div></a>
    <a href="/fr/bonus/vip/" class="bonus-pill"><span class="bonus-pill-icon">👑</span><div class="bonus-pill-name">VIP</div><div class="bonus-pill-amount">Exclusif</div></a>
  </div>
</section>
<section class="section">
  <div class="sec-eyebrow">Régions</div>
  <h2 class="sec-title">Casino par <span>Ville</span></h2>
  <div class="rel-grid">
    <a href="/fr/villes/geneve/" class="rel-card">🇨🇭 Genève<div class="rel-sub">Casino en ligne Genève</div></a>
    <a href="/fr/villes/lausanne/" class="rel-card">🇨🇭 Lausanne<div class="rel-sub">Casino Vaud Romandie</div></a>
    <a href="/fr/villes/zurich-fr/" class="rel-card">🇨🇭 Zurich<div class="rel-sub">Casino bilingue FR/DE</div></a>
    <a href="/fr/villes/berne/" class="rel-card">🇨🇭 Berne<div class="rel-sub">Casino Capitale</div></a>
    <a href="/fr/villes/bale/" class="rel-card">🇨🇭 Bâle<div class="rel-sub">Casino Tripoint</div></a>
    <a href="/fr/villes/neuchatel/" class="rel-card">🇨🇭 Neuchâtel<div class="rel-sub">Casino Lac</div></a>
  </div>
</section>
'.$FOOTER_FR.$BNAV_FR.'<script>document.querySelectorAll(".fq").forEach(q=>q.addEventListener("click",()=>q.closest(".faq-item").classList.toggle("open")));</script></body></html>';

file_put_contents($BASE.'/fr/index.html',$frHP);
$allPages[]='fr/';
echo "  ✅ FR homepage\n";

// DE HOMEPAGE
$deHP = '<!DOCTYPE html><html lang="de"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808"><title>Bestes Online Casino Schweiz — CHF Bonus & Exklusive Angebote | HurrahCasino.ch</title><meta name="description" content="Die besten Online Casinos für Schweizer Spieler. Vergleichen Sie CHF-Boni, Freispiele, No-Deposit-Boni. Legale CFMJ-Seiten. Schweizer Casino Leitfaden auf Deutsch."><link rel="canonical" href="https://hurrahcasino.ch/de/"><link rel="alternate" hreflang="fr" href="https://hurrahcasino.ch/fr/"><link rel="alternate" hreflang="de" href="https://hurrahcasino.ch/de/"><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'</style></head><body>
<div class="lang-bar"><a href="/fr/" class="lang-btn">🇨🇭 Français</a><a href="/de/" class="lang-btn active">🇩🇪 Deutsch</a></div>
'.$NAV_DE.'
<div class="swiss-divider"></div>
<section class="hero">
  <div class="hero-badge">🇨🇭 Geprüfte Casinos für die Schweiz</div>
  <h1>Bestes Online Casino<br><em>Schweiz Deutsch</em></h1>
  <p class="hero-desc">'.$deDesc.'</p>
  <div class="hero-btns"><a href="#casinos" class="btn-primary">🎰 Casinos Ansehen</a><a href="/de/bonus/" class="btn-secondary">🎁 Beste Boni</a></div>
</section>
<div class="stats-bar">
  <div class="stat-item"><span class="stat-num">40+</span><div class="stat-lbl">Getestete Casinos</div></div>
  <div class="stat-item"><span class="stat-num">CHF</span><div class="stat-lbl">CHF Einzahlungen</div></div>
  <div class="stat-item"><span class="stat-num">CFMJ</span><div class="stat-lbl">Legale Seiten</div></div>
  <div class="stat-item"><span class="stat-num">DE/FR</span><div class="stat-lbl">Zweisprachig</div></div>
  <div class="stat-item"><span class="stat-num">24/7</span><div class="stat-lbl">Kundendienst</div></div>
</div>
<div class="trust-strip">
  <div class="trust-badge">🔒 SSL Gesichert</div>
  <div class="trust-badge">⚖️ CFMJ Lizenz</div>
  <div class="trust-badge">🏦 CHF Zahlungen</div>
  <div class="trust-badge">🇨🇭 Für CH Spieler</div>
  <div class="trust-badge">⚡ Schnelle Auszahlung</div>
  <div class="trust-badge">📱 Mobile Ready</div>
</div>
<section class="section" id="casinos">
  <div class="sec-eyebrow">Top Bewertung</div>
  <h2 class="sec-title">Beste Casinos <span>Schweiz</span></h2>
  <p style="color:var(--gray);font-size:13px;margin-bottom:16px">Geprüfte Auswahl. Gesponserter Inhalt.</p>
  <div class="casino-grid">'.casinoCards($DE_CASINOS,'de','de','casino-schweiz-',$AFF[1]).'</div>
</section>
<div class="cta-section">
  <div class="cta-title">🎁 <span>Exklusiver Schweizer Bonus</span></div>
  <div class="cta-sub">Gesponsertes Angebot · Verantwortungsvolles Spielen · Nur ab 18</div>
  <a href="'.$AFF[1].'" target="_blank" rel="noopener sponsored" class="cta-btn">Meinen Bonus Beanspruchen →</a>
  <span class="cta-sponsored">Gesponserter Link — Glücksspiel kann süchtig machen</span>
</div>
<section class="section">
  <div class="sec-eyebrow">Beliebte Angebote</div>
  <h2 class="sec-title">Casino Bonus <span>Schweiz</span></h2>
  <div class="bonus-grid">
    <a href="/de/bonus/ohne-einzahlung/" class="bonus-pill"><span class="bonus-pill-icon">🎁</span><div class="bonus-pill-name">Ohne Einzahlung</div><div class="bonus-pill-amount">Kostenlos</div></a>
    <a href="/de/bonus/freispiele/" class="bonus-pill"><span class="bonus-pill-icon">🎰</span><div class="bonus-pill-name">Freispiele</div><div class="bonus-pill-amount">50-500 Spins</div></a>
    <a href="/de/bonus/willkommensbonus/" class="bonus-pill"><span class="bonus-pill-icon">💰</span><div class="bonus-pill-name">Willkommen</div><div class="bonus-pill-amount">100-200%</div></a>
    <a href="/de/bonus/cashback/" class="bonus-pill"><span class="bonus-pill-icon">💳</span><div class="bonus-pill-name">Cashback</div><div class="bonus-pill-amount">10-20%</div></a>
    <a href="/de/bonus/bitcoin/" class="bonus-pill"><span class="bonus-pill-icon">₿</span><div class="bonus-pill-name">Bitcoin</div><div class="bonus-pill-amount">+15% extra</div></a>
    <a href="/de/bonus/twint/" class="bonus-pill"><span class="bonus-pill-icon">📱</span><div class="bonus-pill-name">TWINT</div><div class="bonus-pill-amount">Gebührenfrei</div></a>
    <a href="/de/bonus/legal/" class="bonus-pill"><span class="bonus-pill-icon">⚖️</span><div class="bonus-pill-name">Legales Casino</div><div class="bonus-pill-amount">CFMJ</div></a>
    <a href="/de/bonus/vip/" class="bonus-pill"><span class="bonus-pill-icon">👑</span><div class="bonus-pill-name">VIP</div><div class="bonus-pill-amount">Exklusiv</div></a>
  </div>
</section>
<section class="section">
  <div class="sec-eyebrow">Regionen</div>
  <h2 class="sec-title">Casino nach <span>Stadt</span></h2>
  <div class="rel-grid">
    <a href="/de/staedte/zuerich/" class="rel-card">🇨🇭 Zürich<div class="rel-sub">Online Casino Zürich</div></a>
    <a href="/de/staedte/bern/" class="rel-card">🇨🇭 Bern<div class="rel-sub">Casino Bundeshauptstadt</div></a>
    <a href="/de/staedte/basel/" class="rel-card">🇨🇭 Basel<div class="rel-sub">Casino Dreiländereck</div></a>
    <a href="/de/staedte/genf/" class="rel-card">🇨🇭 Genf<div class="rel-sub">Casino Genf international</div></a>
    <a href="/de/staedte/lausanne/" class="rel-card">🇨🇭 Lausanne<div class="rel-sub">Casino Waadt</div></a>
    <a href="/de/staedte/luzern/" class="rel-card">🇨🇭 Luzern<div class="rel-sub">Casino Herz der Schweiz</div></a>
  </div>
</section>
'.$FOOTER_DE.$BNAV_DE.'</body></html>';

file_put_contents($BASE.'/de/index.html',$deHP);
$allPages[]='de/';
echo "  ✅ DE homepage\n";

// ROOT REDIRECT
file_put_contents($BASE.'/index.html','<!DOCTYPE html><html><head><meta charset="UTF-8"><meta http-equiv="refresh" content="0;url=/fr/"><title>HurrahCasino.ch</title><link rel="icon" type="image/png" href="/favicon.png"></head><body><script>window.location.href="/fr/";</script></body></html>');

// LISTING PAGES
$listings = [
    ['path'=>'fr/bonus','title'=>'Tous les Bonus Casino Suisse','pages'=>$FR_BONUS,'lang'=>'fr','pfx'=>''],
    ['path'=>'de/bonus','title'=>'Alle Casino Boni Schweiz','pages'=>$DE_BONUS,'lang'=>'de','pfx'=>''],
    ['path'=>'fr/casino','title'=>'Tous les Casinos en Ligne Suisse','pages'=>$FR_CASINOS,'lang'=>'fr','pfx'=>'casino-suisse-'],
    ['path'=>'de/casino','title'=>'Alle Online Casinos Schweiz','pages'=>$DE_CASINOS,'lang'=>'de','pfx'=>'casino-schweiz-'],
];

foreach ($listings as $lst) {
    $isDE=$lst['lang']==='de';
    $nav=$isDE?$NAV_DE:$NAV_FR;
    $bnav=$isDE?$BNAV_DE:$BNAV_FR;
    $footer=$isDE?$FOOTER_DE:$FOOTER_FR;
    $html='<!DOCTYPE html><html lang="'.$lst['lang'].'"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><title>'.$lst['title'].' | HurrahCasino.ch</title><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'
.ph{padding:20px}.ph h1{font-size:20px;font-weight:900;margin-bottom:6px}.ph h1 span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.lst{padding:0 20px 100px;display:flex;flex-direction:column;gap:8px}
.it{background:var(--dark2);border-radius:11px;padding:11px 13px;display:flex;align-items:center;gap:8px;text-decoration:none;color:var(--white);border:1px solid var(--border)}
.it:hover{border-color:var(--border2)}.it-h{flex:1;font-size:13px;font-weight:700;line-height:1.3}.it-arr{color:var(--red2);font-size:16px}
</style></head><body>'.$nav.'<div class="ph"><h1>'.str_replace(['Casino','Bonus','Alle','Tous'],['<span>Casino</span>','<span>Bonus</span>','Alle','Tous'],$lst['title']).'</h1></div><div class="lst">';
    foreach ($lst['pages'] as $p) {
        $slug=isset($p['slug'])?$lst['pfx'].$p['slug']:'';
        $title=isset($p['h1'])?$p['h1']:(isset($p['name'])?$p['name'].' — '.$p['bonus']:'');
        $url='/'.$lst['path'].'/'.$slug.'/';
        $html.='<a href="'.$url.'" class="it"><div class="it-h">'.htmlspecialchars($title).'</div><div class="it-arr">›</div></a>';
    }
    $html.='</div>'.$footer.$bnav.'</body></html>';
    file_put_contents($BASE.'/'.$lst['path'].'/index.html',$html);
    echo "  ✅ /".$lst['path']."/\n";
}

// JEUX/SPIELE/VILLES LISTINGS
foreach(['fr/jeux'=>[$JEUX,'fr_h1','fr_slug','fr'],'de/spiele'=>[$JEUX,'de_h1','de_slug','de'],'fr/villes'=>[$VILLES,'fr_h1','fr_slug','fr'],'de/staedte'=>[$VILLES,'de_h1','de_slug','de'],'fr/guide'=>[$GUIDES,'fr_h1','fr_slug','fr'],'de/guide'=>[$GUIDES,'de_h1','de_slug','de']] as $path=>[$data,$hkey,$skey,$lang]){
    $isDE=$lang==='de';
    $nav=$isDE?$NAV_DE:$NAV_FR;$bnav=$isDE?$BNAV_DE:$BNAV_FR;$footer=$isDE?$FOOTER_DE:$FOOTER_FR;
    $title=ucfirst(str_replace(['/','-'],[' ',' '],$path));
    $html='<!DOCTYPE html><html lang="'.$lang.'"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><title>'.$title.' | HurrahCasino.ch</title><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'
.ph{padding:20px}.ph h1{font-size:20px;font-weight:900;margin-bottom:6px}.ph h1 span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.lst{padding:0 20px 100px;display:flex;flex-direction:column;gap:8px}
.it{background:var(--dark2);border-radius:11px;padding:11px 13px;display:flex;align-items:center;gap:8px;text-decoration:none;color:var(--white);border:1px solid var(--border)}
.it:hover{border-color:var(--border2)}.it-h{flex:1;font-size:13px;font-weight:700}.it-arr{color:var(--red2);font-size:16px}
</style></head><body>'.$nav.'<div class="ph"><h1>'.$title.'</h1></div><div class="lst">';
    foreach($data as $p){$html.='<a href="/'.$path.'/'.$p[$skey].'/" class="it"><div class="it-h">'.htmlspecialchars($p[$hkey]).'</div><div class="it-arr">›</div></a>';}
    $html.='</div>'.$footer.$bnav.'</body></html>';
    file_put_contents($BASE.'/'.$path.'/index.html',$html);
    echo "  ✅ /".$path."/\n";
}

// FAVICON
$fav=imagecreatetruecolor(64,64);
$bg=imagecolorallocate($fav,212,0,0);$white=imagecolorallocate($fav,255,255,255);
imagefilledrectangle($fav,0,0,63,63,$bg);
imagefilledellipse($fav,32,32,40,40,$white);
imagepng($fav,$BASE.'/favicon.png');
imagedestroy($fav);
echo "  ✅ favicon\n";

// ROBOTS
file_put_contents($BASE.'/robots.txt',"User-agent: *\nAllow: /\n\nSitemap: https://hurrahcasino.ch/sitemap.xml\n");

// SITEMAP
$date=date('Y-m-d');
$sm='<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
$sm.='<url><loc>https://hurrahcasino.ch/fr/</loc><lastmod>'.$date.'</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>'."\n";
$sm.='<url><loc>https://hurrahcasino.ch/de/</loc><lastmod>'.$date.'</lastmod><changefreq>daily</changefreq><priority>1.0</priority></url>'."\n";
foreach($allPages as $p){
    $prio=(substr_count($p,'/')==2)?'0.9':'0.7';
    $sm.='<url><loc>https://hurrahcasino.ch/'.$p.'</loc><lastmod>'.$date.'</lastmod><changefreq>weekly</changefreq><priority>'.$prio.'</priority></url>'."\n";
}
$sm.='</urlset>';
file_put_contents($BASE.'/sitemap.xml',$sm);
$total=substr_count($sm,'<url>');

echo "\n=== DONE ===\n";
echo "✅ ".$pc." pages générées\n";
echo "✅ Sitemap: ".$total." URLs\n";
$fr_count=count(array_filter($allPages,fn($p)=>str_starts_with($p,'fr')));
$de_count=count(array_filter($allPages,fn($p)=>str_starts_with($p,'de')));
echo "✅ FR: ".$fr_count." pages\n";
echo "✅ DE: ".$de_count." pages\n";
echo "⚠️  rm gen_hurrahcasino.php\n";
