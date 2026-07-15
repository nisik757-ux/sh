<?php
/**
 * TWINT Casino Pages Generator for hurrahcasino.ch
 * 30+ unique pages targeting Swiss TWINT casino queries
 */

$OPENAI_KEY = 'OPENAI_KEY_HERE';
$ANTHROPIC_KEY = 'ANTHROPIC_KEY_HERE';

$BASE = '/home/admin/web/hurrahcasino.ch/public_html';
$IMG_DIR = $BASE . '/images/fr';

$AFF = [
    'https://track.smartlink-gh.site/sl?id=687a0b103913fc6f4740965e&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67977ae8d54db995337cdfd9&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67935cda9c50ac5df850a615&pid=3935',
];

if (!is_dir($BASE.'/fr/twint')) mkdir($BASE.'/fr/twint', 0755, true);
if (!is_dir($IMG_DIR)) mkdir($IMG_DIR, 0755, true);

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
    if (file_exists($jpg)) return '/images/fr/'.basename($jpg);
    $data = json_encode(['model'=>'gpt-image-1','prompt'=>$prompt.', professional Swiss casino website, luxury, no text','n'=>1,'size'=>'1024x1024','output_format'=>'png']);
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
    return '/images/fr/'.basename($jpg);
}

// ============ CSS (same as hurrahcasino) ============
$CSS = '
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
:root{--red:#D40000;--red2:#FF2A2A;--dark:#080808;--dark2:#111;--dark3:#1a1a1a;--gold:#FFD700;--gold2:#FFA500;--white:#fff;--gray:#888;--glass:rgba(255,255,255,.05);--glass2:rgba(255,255,255,.08);--border:rgba(255,255,255,.08);--border2:rgba(212,0,0,.3);--twint:#00A0E0}
html{scroll-behavior:smooth}
body{background:var(--dark);color:var(--white);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;overflow-x:hidden;min-height:100vh;padding-bottom:70px}
body::before{content:"";position:fixed;top:0;left:0;right:0;bottom:0;background:radial-gradient(ellipse at 20% 50%,rgba(212,0,0,.08) 0%,transparent 50%),radial-gradient(ellipse at 80% 20%,rgba(0,160,224,.04) 0%,transparent 40%);pointer-events:none;z-index:0}
.topbar{position:sticky;top:0;z-index:100;background:rgba(8,8,8,.97);backdrop-filter:blur(24px);border-bottom:1px solid var(--border);padding:0 18px;height:62px;display:flex;align-items:center;justify-content:space-between}
.logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.logo-icon{width:38px;height:38px;background:linear-gradient(135deg,var(--red),var(--red2));border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:21px;box-shadow:0 4px 20px rgba(212,0,0,.35)}
.logo-text{font-size:18px;font-weight:900}
.logo-text span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.nav-links{display:none}
@media(min-width:768px){.nav-links{display:flex;gap:4px;align-items:center}.nav-links a{color:rgba(255,255,255,.65);font-size:13px;font-weight:500;padding:7px 13px;border-radius:8px;transition:.2s;text-decoration:none}.nav-links a:hover{background:var(--glass2);color:#fff}.topbar{padding:0 36px}body{padding-bottom:0}.bnav{display:none!important}.wrap{max-width:900px;margin:0 auto}}
.cta-top{background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:8px 16px;border-radius:10px;font-size:12px;font-weight:800;text-decoration:none;box-shadow:0 4px 15px rgba(212,0,0,.35);white-space:nowrap}
.sponsored-label{font-size:9px;font-weight:400;opacity:.7;display:block;text-align:center}
.hero{position:relative;overflow:hidden;padding:44px 20px 36px;text-align:center;background:linear-gradient(160deg,#0d0000,#080808)}
.hero::after{content:"";position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--twint),var(--red),var(--twint),transparent)}
.twint-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(0,160,224,.12);border:1px solid rgba(0,160,224,.3);color:#00C8FF;padding:6px 16px;border-radius:20px;font-size:12px;font-weight:700;margin-bottom:18px;position:relative;z-index:1;letter-spacing:.5px}
.twint-logo{font-size:20px}
.hero h1{font-size:clamp(22px,5vw,48px);font-weight:900;line-height:1.15;margin-bottom:12px;position:relative;z-index:1}
.hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--twint),#00C8FF,var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero-sub{font-size:15px;color:rgba(255,255,255,.58);max-width:540px;margin:0 auto 24px;line-height:1.68;position:relative;z-index:1}
.hero-btns{display:flex;gap:11px;justify-content:center;flex-wrap:wrap;position:relative;z-index:1}
.btn-twint{background:linear-gradient(135deg,var(--twint),#0078A8);color:#fff;padding:13px 26px;border-radius:12px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 8px 28px rgba(0,160,224,.3);display:inline-block}
.btn-gold{background:linear-gradient(135deg,var(--gold),var(--gold2));color:#0A0F0B;padding:13px 22px;border-radius:12px;font-weight:800;font-size:14px;text-decoration:none;display:inline-block}
.twint-info{display:flex;overflow-x:auto;gap:0;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.twint-info::-webkit-scrollbar{display:none}
.ti-item{flex:1;min-width:120px;padding:14px 12px;text-align:center;border-right:1px solid var(--border)}
.ti-n{font-size:18px;font-weight:900;color:var(--twint);display:block}
.ti-l{font-size:10px;color:var(--gray);margin-top:2px;font-weight:500}
.trust{display:flex;overflow-x:auto;gap:8px;padding:12px 18px;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.trust::-webkit-scrollbar{display:none}
.tbadge{flex-shrink:0;display:flex;align-items:center;gap:6px;background:var(--glass);border:1px solid var(--border);border-radius:9px;padding:6px 12px;font-size:11px;font-weight:600;white-space:nowrap}
.wrap{padding:0 18px}
.section{padding:28px 18px}
.eyebrow{display:inline-block;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--twint);margin-bottom:8px}
.sec-title{font-size:clamp(17px,3vw,26px);font-weight:900;line-height:1.22;margin-bottom:12px}
.sec-title span{background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.cta-box{margin:0 0 22px;background:linear-gradient(135deg,#001A2E,#000D1A);border:1px solid rgba(0,160,224,.2);border-radius:18px;padding:22px 18px;text-align:center}
.cta-title{font-size:19px;font-weight:900;margin-bottom:4px}
.cta-title span{background:linear-gradient(135deg,var(--twint),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.cta-sub{font-size:12px;color:var(--gray);margin-bottom:14px;line-height:1.5}
.cta-btn{display:inline-block;background:linear-gradient(135deg,var(--twint),#0078A8);color:#fff;padding:13px 28px;border-radius:11px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 8px 24px rgba(0,160,224,.3)}
.cta-sponsored{font-size:10px;color:var(--gray);margin-top:6px;display:block}
.content-hero{background:linear-gradient(160deg,#001020,#080808);padding:34px 18px 22px;border-bottom:1px solid var(--border)}
.bc{display:flex;gap:6px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
.bc a{color:var(--gray);font-size:11px;text-decoration:none}
.bc a:hover{color:var(--twint)}
.bc span{color:var(--gray);font-size:11px}
.content-hero h1{font-size:clamp(19px,4vw,34px);font-weight:900;line-height:1.22;margin-bottom:8px}
.content-hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.content-hero p{font-size:13px;color:var(--gray);line-height:1.65}
.content-body{padding:20px 18px;font-size:13px;line-height:1.78;color:rgba(255,255,255,.85)}
.content-body h2{font-size:17px;font-weight:800;margin:22px 0 10px;color:#fff;border-left:3px solid var(--twint);padding-left:10px}
.content-body h3{font-size:15px;font-weight:700;margin:16px 0 8px;color:#00C8FF}
.content-body p{margin-bottom:12px}
.content-body ul,.content-body ol{margin:0 0 12px 18px}
.content-body li{margin-bottom:6px}
.content-body strong{color:#fff}
.content-body a{color:var(--twint);font-weight:600;text-decoration:none}
.steps{display:flex;flex-direction:column;gap:10px;margin:16px 0}
.step{background:var(--dark2);border-radius:12px;padding:14px;display:flex;gap:12px;border:1px solid var(--border)}
.snum{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--twint),#0078A8);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#fff;flex-shrink:0}
.stxt{font-size:13px;color:var(--gray);line-height:1.5}
.stxt strong{color:var(--white);display:block;margin-bottom:3px}
.compare-table{width:100%;border-collapse:collapse;margin:16px 0;font-size:13px}
.compare-table th{background:rgba(0,160,224,.12);color:var(--twint);padding:10px 12px;text-align:left;font-weight:700;border-bottom:1px solid var(--border)}
.compare-table td{padding:10px 12px;border-bottom:1px solid rgba(255,255,255,.04);color:rgba(255,255,255,.8)}
.compare-table tr:hover td{background:rgba(255,255,255,.02)}
.highlight-row td{color:var(--twint);font-weight:700}
.faq-item{background:var(--dark2);border-radius:11px;margin-bottom:8px;overflow:hidden;border:1px solid var(--border)}
.fq{padding:13px 15px;font-size:13px;font-weight:600;display:flex;justify-content:space-between;align-items:center;cursor:pointer;line-height:1.4}
.fi{color:var(--twint);font-size:18px;transition:.2s;flex-shrink:0;margin-left:8px}
.faq-item.open .fi{transform:rotate(45deg)}
.fa{font-size:12px;color:var(--gray);line-height:1.65;max-height:0;overflow:hidden;transition:max-height .3s,padding .3s}
.faq-item.open .fa{max-height:300px;padding:0 15px 14px}
.rel-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
@media(min-width:480px){.rel-grid{grid-template-columns:repeat(3,1fr)}}
.rel-card{background:var(--dark2);border-radius:10px;padding:10px;border:1px solid var(--border);display:block;font-size:12px;font-weight:700;text-decoration:none;color:var(--white);line-height:1.4}
.rel-card:hover{border-color:rgba(0,160,224,.3)}
.rel-sub{font-size:11px;color:var(--gray);margin-top:3px}
.footer{background:var(--dark2);border-top:1px solid var(--border);padding:24px 18px;text-align:center}
.footer-logo{font-size:18px;font-weight:900;margin-bottom:8px}
.footer-logo span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.footer-links{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-bottom:12px}
.footer-links a{color:var(--gray);font-size:12px;text-decoration:none}
.footer-disc{font-size:10px;color:rgba(255,255,255,.25);line-height:1.65;max-width:600px;margin:0 auto}
.bnav{position:fixed;bottom:0;left:0;right:0;background:rgba(8,8,8,.97);backdrop-filter:blur(20px);border-top:1px solid var(--border);display:flex;padding:7px 0 max(7px,env(safe-area-inset-bottom));z-index:100}
.bn{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:var(--gray);font-size:10px;font-weight:600}
.bn.on{color:var(--twint)}
.bn-i{font-size:20px}
';

$NAV = '<nav class="topbar"><a href="/fr/" class="logo"><div class="logo-icon">🎰</div><div class="logo-text">Hurrah<span>Casino</span></div></a><div class="nav-links"><a href="/fr/casino/">Casinos</a><a href="/fr/bonus/">Bonus</a><a href="/fr/twint/" style="color:var(--twint)">TWINT</a><a href="/fr/jeux/">Jeux</a><a href="/de/">🇩🇪 DE</a></div><a href="'.$AFF[0].'" target="_blank" rel="noopener sponsored" class="cta-top">Jouer →<span class="sponsored-label">Sponsorisé</span></a></nav>';
$BNAV = '<nav class="bnav"><a href="/fr/" class="bn"><span class="bn-i">🏠</span>Accueil</a><a href="/fr/casino/" class="bn"><span class="bn-i">🎰</span>Casinos</a><a href="/fr/bonus/" class="bn"><span class="bn-i">🎁</span>Bonus</a><a href="/fr/twint/" class="bn on"><span class="bn-i">📱</span>TWINT</a><a href="/fr/guide/" class="bn"><span class="bn-i">📖</span>Guide</a></nav>';
$FOOTER = '<footer class="footer"><div class="footer-logo">Hurrah<span>Casino</span>.ch</div><div class="footer-links"><a href="/fr/">Accueil</a><a href="/fr/casino/">Casinos</a><a href="/fr/bonus/">Bonus</a><a href="/fr/twint/">TWINT</a><a href="/fr/guide/">Guides</a><a href="/de/">Deutsch</a></div><p class="footer-disc">HurrahCasino.ch est un site de comparaison. Contenu sponsorisé. Le jeu peut créer une dépendance. Interdit aux moins de 18 ans. © '.date('Y').' HurrahCasino.ch</p></footer>';

function buildPage($h1, $meta, $bc, $intro, $body, $faqHtml, $relHtml, $aff, $img) {
    global $NAV, $BNAV, $FOOTER, $CSS, $AFF;
    $imgTag = $img ? '<img src="'.$img.'" alt="'.htmlspecialchars($h1).'" style="width:100%;height:220px;object-fit:cover;display:block">' : '';
    return '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808"><title>'.htmlspecialchars($h1).' | HurrahCasino.ch</title><meta name="description" content="'.htmlspecialchars($meta).'"><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'</style></head><body>'.$NAV.$imgTag.'<div class="content-hero"><div class="bc">'.$bc.'</div><h1><em>'.htmlspecialchars($h1).'</em></h1><p>'.$intro.'</p></div><div class="cta-box" style="margin:16px 18px"><div class="cta-title">📱 <span>Casino TWINT Suisse</span></div><div class="cta-sub">Sponzorirana vsebina · Jouez responsablement · +18 uniquement</div><a href="'.$aff.'" target="_blank" rel="noopener sponsored" class="cta-btn">Jouer avec TWINT →</a><span class="cta-sponsored">Lien sponsorisé — jouez responsablement</span></div><div class="content-body">'.$body.'</div><div style="padding:0 18px 18px"><div style="font-size:16px;font-weight:900;margin-bottom:12px">❓ Questions Fréquentes TWINT</div>'.$faqHtml.'</div><div style="padding:0 18px 18px"><div style="font-size:16px;font-weight:900;margin-bottom:12px">📱 Autres Guides TWINT</div><div class="rel-grid">'.$relHtml.'</div></div>'.$FOOTER.$BNAV.'<script>document.querySelectorAll(".fq").forEach(q=>q.addEventListener("click",()=>q.closest(".faq-item").classList.toggle("open")));</script></body></html>';
}

function faqHtml($qs) {
    $h='';
    foreach($qs as $q=>$a) $h.='<div class="faq-item"><div class="fq">'.htmlspecialchars($q).' <span class="fi">+</span></div><div class="fa">'.$a.'</div></div>';
    return $h;
}

// ============ 30 TWINT PAGES ============
$PAGES = [
// PRINCIPALES
['slug'=>'casino-twint','h1'=>'Casino TWINT Suisse — Jouer avec l\'App de Paiement Suisse Numéro 1','meta'=>'Casino en ligne TWINT Suisse. Dépôt et retrait via TWINT. L\'application de paiement la plus populaire en Suisse pour les casinos en ligne. Guide complet.','angle'=>'TWINT est L\'application de paiement suisse par excellence utilisée par plus de 4 millions de suisses. Explique pourquoi TWINT est parfait pour les casinos: instantané, sécurisé, sans frais cachés, disponible sur tout smartphone suisse. Contexte: TWINT né en Suisse en 2016, partenariat avec toutes les grandes banques suisses.','img'=>'TWINT casino Switzerland blue white Swiss payment app casino mobile luxury','steps'=>true],

['slug'=>'deposer-casino-twint','h1'=>'Déposer au Casino avec TWINT en Suisse — Guide Étape par Étape','meta'=>'Comment déposer dans un casino en ligne avec TWINT en Suisse. Étapes simples, instantané, sécurisé. Guide pratique pour joueurs suisses utilisant TWINT.','angle'=>'Guide ultra-pratique pour faire son premier dépôt casino via TWINT depuis la Suisse. Étapes concrètes: ouvrir app TWINT, choisir montant, scanner QR code du casino ou utiliser numéro de téléphone, confirmation instantanée. Erreurs fréquentes et comment les éviter. Minimum de dépôt en CHF.','img'=>'TWINT deposit casino Switzerland step by step guide QR code scan mobile','steps'=>true],

['slug'=>'retrait-casino-twint','h1'=>'Retrait Casino vers TWINT Suisse — Recevoir ses Gains Rapidement','meta'=>'Comment retirer ses gains de casino vers TWINT en Suisse. Délais réels, limites, solutions si problème. Guide complet retrait casino TWINT suisse.','angle'=>'Le retrait casino vers TWINT est la préoccupation principale des joueurs suisses. Explique le processus exact: demande de retrait, vérification identité si requise, délais réels (pas marketing), limites TWINT pour retraits, que faire si retrait bloqué. Comparaison vitesse TWINT vs virement bancaire vs carte.','img'=>'TWINT withdrawal casino Switzerland fast receive money Swiss blue','steps'=>true],

['slug'=>'bonus-casino-twint','h1'=>'Bonus Casino TWINT Suisse — Offres Exclusives pour Utilisateurs TWINT','meta'=>'Bonus casino exclusifs pour dépôts TWINT en Suisse. Free spins, bonus bienvenue, cashback TWINT. Meilleures offres pour joueurs suisses utilisant TWINT.','angle'=>'Certains casinos offrent des bonus SPÉCIAUX pour les dépôts TWINT. Explique pourquoi, quels casinos ont des promotions exclusives TWINT, comment les activer, et comment maximiser sa valeur quand on joue avec TWINT depuis la Suisse.','img'=>'TWINT bonus casino Switzerland exclusive offer gift golden blue Swiss','steps'=>false],

['slug'=>'casino-twint-sans-depot','h1'=>'Casino TWINT Sans Dépôt Suisse — Bonus Gratuit avec TWINT','meta'=>'Casino bonus sans dépôt avec TWINT en Suisse. Jouez gratuitement et utilisez TWINT pour retirer vos gains. Offres vérifiées pour joueurs suisses.','angle'=>'Combiner bonus sans dépôt ET TWINT pour retirer les gains. Explique comment obtenir un bonus gratuit, jouer, gagner, et retirer directement sur TWINT sans jamais utiliser sa carte bancaire. La stratégie la plus sûre pour les nouveaux joueurs suisses.','img'=>'TWINT no deposit bonus casino Switzerland free play Swiss mobile blue','steps'=>false],

['slug'=>'casino-acceptant-twint','h1'=>'Casinos qui Acceptent TWINT en Suisse — Liste Complète et Vérifiée','meta'=>'Liste complète des casinos en ligne qui acceptent TWINT en Suisse. Vérifiés, sécurisés, avec bonus disponibles. Guide pour choisir le meilleur casino TWINT suisse.','angle'=>'Guide de sélection des casinos qui VRAIMENT acceptent TWINT (pas tous le font). Critères de sélection: TWINT disponible pour dépôt ET retrait, licence reconnue, bonus en CHF, support français. Pourquoi certains casinos n\'acceptent pas encore TWINT et les alternatives.','img'=>'Casino TWINT accepted list Switzerland verified secure blue Swiss luxury','steps'=>false],

['slug'=>'twint-casino-bonus-bienvenue','h1'=>'Bonus de Bienvenue Casino TWINT Suisse — Doublez votre Premier Dépôt','meta'=>'Bonus de bienvenue casino avec TWINT en Suisse. 100% à 200% sur votre premier dépôt TWINT. Guide complet pour maximiser son bonus avec TWINT.','angle'=>'Le bonus bienvenue activé via TWINT. Explique si le bonus varie selon la méthode de paiement, comment calculer la vraie valeur du bonus en CHF avec TWINT, conditions de mise adaptées au marché suisse, et quel casino offre le meilleur bonus bienvenue pour les utilisateurs TWINT.','img'=>'Welcome bonus TWINT casino Switzerland 200 percent CHF blue gold luxury','steps'=>false],

['slug'=>'twint-casino-free-spins','h1'=>'Free Spins Casino TWINT Suisse — Tours Gratuits pour Dépôts TWINT','meta'=>'Free spins pour dépôts TWINT casino Suisse. 50 à 500 tours gratuits en déposant avec TWINT. Guide des meilleures offres de free spins TWINT.','angle'=>'Les free spins liés aux dépôts TWINT. Quels casinos offrent des tours gratuits spécifiquement pour les dépôts via TWINT, comment les activer, quels slots sont éligibles, et les conditions réelles pour retirer les gains des free spins vers TWINT.','img'=>'Free spins TWINT casino Switzerland golden reels blue Swiss mobile','steps'=>false],

['slug'=>'twint-casino-cashback','h1'=>'Cashback Casino TWINT Suisse — Récupérez 10-20% de vos Pertes','meta'=>'Cashback casino pour joueurs TWINT en Suisse. Récupérez jusqu\'à 20% de vos pertes en jouant via TWINT. Meilleurs programmes cashback TWINT.','angle'=>'Cashback spécifique aux utilisateurs TWINT en Suisse. Certains casinos offrent un cashback plus élevé pour TWINT. Explique comment calculer son cashback en CHF, quelle période est couverte, et comment optimiser son cashback en combinant TWINT et les bons casinos.','img'=>'Cashback TWINT casino Switzerland money return blue weekly Swiss','steps'=>false],

['slug'=>'twint-casino-securite','h1'=>'Sécurité Casino TWINT Suisse — Pourquoi TWINT est la Méthode la Plus Sûre','meta'=>'Sécurité casino TWINT Suisse. Pourquoi TWINT est plus sûr que carte bancaire pour casino. Protection données, authentification, garanties Postfinance et UBS.','angle'=>'TWINT est soutenu par les grandes banques suisses (PostFinance, UBS, ZKB, etc). Explique pourquoi c\'est la méthode la plus sûre pour jouer au casino depuis la Suisse: authentification à deux facteurs intégrée, pas de données bancaires partagées, protection client banques suisses, signalement fraude instantané.','img'=>'TWINT security casino Switzerland safe bank protection Swiss blue official','steps'=>false],

['slug'=>'twint-casino-limites','h1'=>'Limites TWINT Casino Suisse — Plafonds et Comment les Augmenter','meta'=>'Limites TWINT pour casino en Suisse. Plafonds journaliers, mensuels, comment les augmenter. Guide pour joueurs suisses qui veulent jouer plus.','angle'=>'Les limites TWINT peuvent bloquer les gros joueurs suisses. Explique les limites standard TWINT (500 CHF/transaction, 3000 CHF/mois), comment les augmenter via son application bancaire, et alternatives pour dépôts plus importants quand TWINT est insuffisant.','img'=>'TWINT limits casino Switzerland increase cap Swiss banking blue luxury','steps'=>false],

['slug'=>'twint-casino-mobile','h1'=>'Casino Mobile TWINT Suisse — Jouer sur iPhone et Android avec TWINT','meta'=>'Casino mobile TWINT Suisse. Jouer sur smartphone avec TWINT. Applications casino compatibles TWINT pour iOS et Android. Guide mobile TWINT casino.','angle'=>'TWINT est une app mobile — l\'expérience naturelle pour les joueurs suisses sur smartphone. Guide de l\'expérience casino mobile avec TWINT: comment ça fonctionne sur iPhone (iOS) et Android, les meilleures apps casino pour Suisse avec intégration TWINT, et pourquoi la combinaison mobile + TWINT est idéale.','img'=>'TWINT mobile casino Switzerland iPhone Android app Swiss blue luxury','steps'=>false],

['slug'=>'twint-casino-geneve','h1'=>'Casino TWINT Genève — Jouer avec TWINT depuis la Cité Internationale','meta'=>'Casino en ligne TWINT depuis Genève. Guide spécifique pour joueurs genevois utilisant TWINT. Casinos disponibles, bonus CHF, support français.','angle'=>'Guide géo-ciblé pour les joueurs de Genève qui utilisent TWINT. Genève ville internationale bilingue FR/EN où TWINT est très répandu. Spécificités genevois: compte en CHF et parfois EUR, casinos qui acceptent les deux devises, et expérience TWINT casino depuis Genève.','img'=>'TWINT casino Geneva Switzerland Lake Leman blue luxury French international','steps'=>false],

['slug'=>'twint-casino-zurich','h1'=>'Casino TWINT Zurich — L\'App Suisse pour Jouer depuis la Capitale Économique','meta'=>'Casino TWINT depuis Zurich. Guide pour joueurs zurichois utilisant TWINT. Casinos bilingues DE/FR, bonus CHF, application TWINT Zurich.','angle'=>'Guide pour les joueurs de Zurich qui utilisent TWINT. Zurich est la capitale économique suisse et TWINT y est omniprésent. Explique comment les zurichois bilingues DE/FR utilisent TWINT pour le casino, les banques zurichoises compatibles TWINT, et les meilleurs casinos disponibles depuis Zurich.','img'=>'TWINT casino Zurich Switzerland economic capital blue luxury skyline','steps'=>false],

['slug'=>'twint-casino-lausanne','h1'=>'Casino TWINT Lausanne — Jouez depuis Lausanne avec l\'App Suisse','meta'=>'Casino TWINT depuis Lausanne. Guide joueurs lausannois. TWINT Vaud, casinos francophones, bonus CHF depuis Lausanne et le canton de Vaud.','angle'=>'Guide pour les joueurs de Lausanne et du canton de Vaud qui utilisent TWINT. Lausanne ville francophone universitaire où les jeunes utilisent massivement TWINT. Spécificités: casinos en français, TWINT avec comptes UBS/BCV/Banque Cantonale Vaudoise, expérience casino depuis le bord du lac Léman.','img'=>'TWINT casino Lausanne Switzerland Vaud lake Olympic blue French luxury','steps'=>false],

['slug'=>'twint-postfinance-casino','h1'=>'Casino TWINT PostFinance Suisse — La Banque Postale pour Jouer','meta'=>'Casino TWINT PostFinance en Suisse. Utiliser TWINT avec compte PostFinance pour casino. Guide pour clients PostFinance qui veulent jouer en ligne.','angle'=>'PostFinance est l\'une des principales banques suisses et un partenaire TWINT majeur. Guide spécifique pour les clients PostFinance qui veulent utiliser TWINT pour le casino: activer TWINT sur compte PostFinance, limites spécifiques PostFinance, et comment optimiser son expérience casino avec PostFinance + TWINT.','img'=>'TWINT PostFinance casino Switzerland post bank yellow blue Swiss luxury','steps'=>false],

['slug'=>'twint-ubs-casino','h1'=>'Casino TWINT UBS Suisse — Jouer au Casino avec TWINT UBS','meta'=>'Casino TWINT UBS en Suisse. Utiliser TWINT avec compte UBS pour casino en ligne. Guide clients UBS pour jouer avec TWINT. Sécurisé et instantané.','angle'=>'UBS est la plus grande banque suisse et ses clients ont accès à TWINT. Guide pour les clients UBS qui veulent utiliser TWINT pour le casino: activation TWINT dans l\'app UBS Key4, limites UBS, sécurité supplémentaire UBS et comment jouer au casino de façon optimale avec un compte UBS.','img'=>'TWINT UBS casino Switzerland big bank blue red luxury Swiss premium','steps'=>false],

['slug'=>'twint-raiffeisen-casino','h1'=>'Casino TWINT Raiffeisen Suisse — La Banque Coopérative pour Jouer','meta'=>'Casino TWINT Raiffeisen Suisse. Utiliser TWINT avec compte Raiffeisen pour casino. Guide clients Raiffeisen. TWINT disponible dans toutes les régions suisses.','angle'=>'Raiffeisen est très présent dans les régions rurales suisses et ses clients utilisent TWINT. Guide pour les clients Raiffeisen qui veulent utiliser TWINT pour le casino: activation dans l\'app Raiffeisen, présence nationale (même en zones rurales), et comment accéder aux casinos en ligne depuis n\'importe quelle région suisse.','img'=>'TWINT Raiffeisen casino Switzerland cooperative bank blue regional Swiss','steps'=>false],

['slug'=>'twint-casino-zkb','h1'=>'Casino TWINT ZKB Suisse — Zürcher Kantonalbank et le Casino','meta'=>'Casino TWINT ZKB (Zürcher Kantonalbank) Suisse. Guide clients ZKB pour casino en ligne avec TWINT. Banque cantonale zurichoise et jeu responsable.','angle'=>'ZKB est la principale banque cantonale zurichoise. Guide pour les clients ZKB qui utilisent TWINT pour le casino: spécificités ZKB, TWINT disponible dans l\'app ZKB, focus sur les joueurs de la région zurichoise et alentours.','img'=>'TWINT ZKB casino Switzerland cantonal bank Zurich blue luxury Swiss','steps'=>false],

['slug'=>'twint-casino-aviator','h1'=>'Jouer à Aviator avec TWINT en Suisse — Le Crash Game et l\'App Suisse','meta'=>'Aviator casino TWINT Suisse. Jouer au jeu crash Aviator en déposant avec TWINT. Guide stratégies Aviator + TWINT pour joueurs suisses.','angle'=>'Aviator est le jeu crash le plus populaire en Suisse et TWINT est la méthode de dépôt préférée. Guide spécifique Aviator + TWINT: comment déposer avec TWINT pour jouer à Aviator, montants recommandés en CHF, stratégies cashout adaptées au budget suisse avec TWINT, et les meilleurs casinos pour Aviator + TWINT.','img'=>'Aviator crash game TWINT Switzerland airplane multiplier blue mobile Swiss','steps'=>false],

['slug'=>'twint-casino-blackjack','h1'=>'Blackjack Casino TWINT Suisse — Stratégie et Dépôt via TWINT','meta'=>'Blackjack casino TWINT Suisse. Jouer au blackjack en déposant avec TWINT. Stratégie de base + guide TWINT pour joueurs suisses de blackjack.','angle'=>'Blackjack avec TWINT en Suisse: la combinaison idéale pour les joueurs analytiques suisses. Guide pratique: déposer avec TWINT pour jouer au blackjack, montants optimaux en CHF pour le blackjack, stratégie de base expliquée et les casinos live blackjack qui acceptent TWINT.','img'=>'Blackjack TWINT casino Switzerland cards strategy blue Swiss luxury','steps'=>false],

['slug'=>'twint-casino-slots','h1'=>'Slots Casino TWINT Suisse — Jouer aux Machines à Sous avec TWINT','meta'=>'Slots casino TWINT Suisse. Jouer aux machines à sous en déposant avec TWINT. Gates of Olympus, Sweet Bonanza avec TWINT. Guide slots TWINT suisse.','angle'=>'Les slots sont les jeux les plus populaires et TWINT le moyen de payer préféré des suisses. Guide pratique slots + TWINT: quels slots choisir avec un budget TWINT en CHF, RTP optimal, comment les free spins s\'activent sur dépôt TWINT, et les meilleures machines à sous disponibles dans les casinos TWINT suisses.','img'=>'Slots casino TWINT Switzerland gaming machines golden blue Swiss luxury','steps'=>false],

['slug'=>'twint-casino-live','h1'=>'Casino Live TWINT Suisse — Vrais Croupiers avec Paiement TWINT','meta'=>'Casino live TWINT Suisse. Jouer avec de vrais croupiers en déposant via TWINT. Baccarat, roulette, blackjack live + TWINT pour joueurs suisses.','angle'=>'Le casino live avec TWINT: l\'expérience casino la plus authentique depuis chez soi en Suisse. Guide: quels casinos live acceptent TWINT, connexion internet requise pour le live (recommandation 10 Mbps+), croupiers francophones disponibles, mises minimales en CHF et comment TWINT simplifie les rechargements pendant une session live.','img'=>'Live casino TWINT Switzerland real dealer stream blue Swiss luxury French','steps'=>false],

['slug'=>'twint-casino-bonus-20-chf','h1'=>'Bonus Casino 20 CHF Sans Dépôt TWINT Suisse — Offre Exclusive','meta'=>'Bonus casino 20 CHF sans dépôt avec TWINT en Suisse. Offre exclusive pour nouveaux joueurs suisses. Retrait via TWINT. Guide bonus 20 CHF TWINT.','angle'=>'Le bonus 20 CHF sans dépôt est très recherché par les suisses (apparaît dans leurs recherches Google). Guide spécifique: où trouver un vrai bonus de 20 CHF sans dépôt en Suisse, comment le retirer vers TWINT, conditions réelles, et pourquoi ce montant spécifique est populaire en Suisse.','img'=>'20 CHF bonus casino TWINT Switzerland no deposit Swiss franc blue gift','steps'=>false],

['slug'=>'twint-casino-bonus-10-chf','h1'=>'Bonus Casino 10 CHF Sans Dépôt TWINT Suisse — Commencer avec 10 CHF','meta'=>'Bonus casino 10 CHF sans dépôt TWINT Suisse. Idéal pour débuter sans risque. Retrait des gains vers TWINT. Guide bonus 10 CHF pour joueurs suisses.','angle'=>'Le bonus 10 CHF sans dépôt: le point d\'entrée idéal pour découvrir le casino en Suisse. Guide: où trouver un vrai bonus 10 CHF, conditions de mise réalistes, comment retirer vers TWINT, et si c\'est suffisant pour réellement tester un casino. Comparaison 10 CHF vs 20 CHF bonus.','img'=>'10 CHF bonus casino TWINT Switzerland no deposit Swiss franc blue small','steps'=>false],

['slug'=>'twint-casino-inscription','h1'=>'S\'inscrire dans un Casino TWINT Suisse — Guide Complet Étape par Étape','meta'=>'Comment s\'inscrire dans un casino TWINT en Suisse. Documents requis, vérification, activation TWINT. Guide inscription casino TWINT pour résidents suisses.','angle'=>'Guide complet d\'inscription dans un casino suisse qui accepte TWINT. Étapes: choisir le bon casino (avec liste de critères), remplir le formulaire avec données suisses, vérification d\'identité (carte d\'identité ou passeport suisse), lier TWINT au compte casino, et faire son premier dépôt. Durée totale du processus.','img'=>'Casino registration TWINT Switzerland sign up steps blue Swiss guide','steps'=>true],

['slug'=>'twint-casino-faq','h1'=>'FAQ Casino TWINT Suisse — Toutes les Réponses à vos Questions TWINT','meta'=>'Questions fréquentes casino TWINT Suisse. Peut-on déposer avec TWINT? Retrait TWINT? Bonus TWINT? Limites? Toutes les réponses pour joueurs suisses.','angle'=>'Article FAQ complet sur TWINT et les casinos en Suisse. Les 15 questions les plus fréquentes des suisses sur TWINT casino: limites, sécurité, banques compatibles, délais, bonus, retrait, vérification. Réponses précises et pratiques. Format Q&R exhaustif pour couvrir toutes les recherches TWINT casino.','img'=>'FAQ casino TWINT Switzerland answers questions Swiss blue guide comprehensive','steps'=>false],

['slug'=>'twint-vs-carte-casino','h1'=>'TWINT vs Carte Bancaire Casino Suisse — Lequel Choisir pour Jouer?','meta'=>'Comparatif TWINT vs carte bancaire pour casino en Suisse. Frais, vitesse, sécurité, limites. Quel mode de paiement choisir pour jouer au casino suisse?','angle'=>'Comparaison honnête et détaillée TWINT vs carte bancaire pour le casino suisse. Tableau comparatif sur: vitesse de dépôt, vitesse de retrait, frais, sécurité, limite, anonymat, disponibilité dans les casinos. Verdict final: pour quel profil de joueur suisse TWINT est meilleur que la carte.','img'=>'TWINT vs credit card casino Switzerland comparison blue versus Swiss','steps'=>false],

['slug'=>'twint-casino-virement','h1'=>'TWINT vs Virement Bancaire Casino Suisse — La Comparaison Définitive','meta'=>'TWINT vs virement bancaire casino Suisse. Rapidité, frais, limites. Pourquoi TWINT surpasse le virement pour la plupart des joueurs suisses.','angle'=>'Comparaison TWINT vs virement bancaire (e-banking suisse) pour le casino. Points clés: TWINT instantané vs virement 1-3 jours ouvrés, TWINT app vs e-banking, limites TWINT (3000 CHF/mois) vs virement (illimité), frais comparés. Pour quel joueur suisse le virement est préférable à TWINT.','img'=>'TWINT vs bank transfer casino Switzerland speed comparison Swiss blue luxury','steps'=>false],

['slug'=>'twint-casino-crypto','h1'=>'TWINT ou Crypto Casino Suisse — Deux Révolutions du Paiement en Suisse','meta'=>'TWINT vs crypto casino en Suisse. Avantages et inconvénients de chaque méthode. Pour quel profil de joueur suisse TWINT ou Bitcoin est la meilleure option?','angle'=>'La Suisse est connue pour TWINT (paiement local) ET le Crypto Valley de Zoug. Comparaison TWINT vs crypto (Bitcoin/USDT) pour casino: TWINT = simple et suisse, crypto = anonyme et sans limites. Pour quel joueur suisse chaque option est optimale. Peut-on combiner les deux?','img'=>'TWINT crypto casino Switzerland comparison two payment methods blue gold','steps'=>false],

['slug'=>'guide-twint-casino-debutant','h1'=>'Guide TWINT Casino Débutant Suisse — Tout ce qu\'il Faut Savoir pour Commencer','meta'=>'Guide TWINT casino pour débutants suisses. Comment utiliser TWINT pour jouer au casino en ligne. Premier dépôt, premier jeu, premier retrait. Tout expliquer.','angle'=>'Guide bienveillant et rassurant pour les suisses qui n\'ont JAMAIS joué au casino en ligne et veulent commencer avec TWINT. Commence par: "si vous lisez ceci, vous êtes sur le point de faire votre première expérience casino en ligne depuis la Suisse". Explique tout de zéro: activer TWINT, choisir un casino, faire son premier dépôt de 10 CHF, jouer aux slots démo d\'abord, retirer ses gains.','img'=>'Beginner guide TWINT casino Switzerland first time easy Swiss blue luxury','steps'=>true],
];

$allPages = [];
$pc = 0;

echo "=== TWINT CASINO PAGES GENERATOR ===\n";
echo count($PAGES)." pages à générer\n\n";

foreach ($PAGES as $page) {
    $pc++;
    $dir = $BASE.'/fr/twint/'.$page['slug'];
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    echo "[".$pc."/".count($PAGES)."] ".$page['h1']."\n";

    // Image
    $imgPath = genImg($page['img'], $page['slug'].'.png', $OPENAI_KEY, $IMG_DIR);
    echo "  🖼️ ".($imgPath ? "✅" : "❌")."\n";

    // Intro
    $intro = claude(
        "Expert casino suisse spécialisé TWINT. 2-3 phrases d'accroche PERCUTANTES pour: \"".$page['h1']."\"\n".
        "Angle: ".$page['angle']."\n".
        "Ces phrases doivent mentionner TWINT spécifiquement, la Suisse, et accrocher immédiatement un joueur suisse. Très vendeur. Français naturel suisse. SEULEMENT 2-3 phrases.",
        $ANTHROPIC_KEY, 200
    );

    // Body
    $bodyPrompt = "Expert casino suisse. Article UNIQUE et COMPLET sur: \"".$page['h1']."\"\n\n".
        "Angle OBLIGATOIRE: ".$page['angle']."\n\n".
        "Contexte suisse précis:\n".
        "- TWINT: app suisse, 4+ millions d'utilisateurs, partenaire des grandes banques CH\n".
        "- Marché: CHF (Franc Suisse), joueurs premium, exigeants\n".
        "- Limites TWINT: 500 CHF/transaction, 3000 CHF/mois (augmentable)\n".
        "- Banques partenaires TWINT: UBS, PostFinance, Raiffeisen, ZKB, BCV, etc.\n".
        "- Régulation casino: CFMJ (Commission fédérale des maisons de jeu)\n\n";

    if ($page['steps']) {
        $bodyPrompt .= "L'article doit inclure:\n1. Introduction contexte TWINT + casino Suisse\n2. Section <h2> guide étapes (avec balises <div class=\"steps\"> et <div class=\"step\"><div class=\"snum\">N</div><div class=\"stxt\"><strong>Titre étape</strong>Description</div></div>)\n3. Section <h2> avantages spécifiques\n4. Section <h2> conseils pratiques et astuces\n5. Section <h2> conclusion avec CTA\n\n";
    } else {
        $bodyPrompt .= "L'article doit avoir:\n4 sections <h2> avec paragraphes <p>\n\n";
    }

    $bodyPrompt .= "800-1000 mots. Données concrètes en CHF. Exemples réels. Vendeur sans être publicitaire. Pas d'année dans le texte. Seulement le HTML.";

    $body = claude($bodyPrompt, $ANTHROPIC_KEY, 1800);

    // FAQ - 4 questions uniques selon le sujet
    $faqPrompt = "4 questions FAQ très spécifiques sur TWINT et casino en Suisse pour: \"".$page['h1']."\"\n".
        "Les questions doivent être CE QUE LES SUISSES CHERCHENT VRAIMENT sur Google (spécifiques, pratiques, pas génériques).\n".
        "Format: q1|||q2|||q3|||q4. SEULEMENT les 4 questions séparées par |||, rien d'autre.";
    $faqRaw = claude($faqPrompt, $ANTHROPIC_KEY, 200);
    $questions = explode('|||', $faqRaw);

    $faqData = [];
    foreach ($questions as $q) {
        $q = trim($q);
        if (empty($q)) continue;
        $ans = claude(
            "2 phrases précises et pratiques: \"".$q."\" pour joueurs suisses utilisant TWINT. ".
            "Réponse concrète avec CHF si pertinent. Français naturel suisse.",
            $ANTHROPIC_KEY, 120
        );
        $faqData[$q] = $ans;
    }

    // Related links
    $relHtml = '';
    foreach (array_slice($PAGES, 0, 8) as $rp) {
        if ($rp['slug'] === $page['slug']) continue;
        $relHtml .= '<a href="/fr/twint/'.$rp['slug'].'/" class="rel-card">'.htmlspecialchars($rp['h1']).'<div class="rel-sub">Casino TWINT Suisse 🇨🇭</div></a>';
        if (substr_count($relHtml, 'rel-card') >= 4) break;
    }

    $bc = '<a href="/fr/">Accueil</a><span>›</span><a href="/fr/bonus/">Bonus</a><span>›</span><a href="/fr/twint/">TWINT</a><span>›</span><span>'.htmlspecialchars($page['slug']).'</span>';
    $affLink = $AFF[$pc % 3];

    $html = buildPage($page['h1'], $page['meta'], $bc, $intro, $body, faqHtml($faqData), $relHtml, $affLink, $imgPath);
    file_put_contents($dir.'/index.html', $html);
    $allPages[] = 'fr/twint/'.$page['slug'].'/';
    echo "  ✅ /fr/twint/".$page['slug']."/\n";
    sleep(1);
}

// TWINT LISTING PAGE
echo "\n📋 TWINT LISTING PAGE\n";
$listingDir = $BASE.'/fr/twint';
$listingHtml = '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808">
<title>Casino TWINT Suisse — Guide Complet | HurrahCasino.ch</title>
<meta name="description" content="Guide complet casino TWINT Suisse. Dépôt, retrait, bonus, banques compatibles. '.count($PAGES).'+ guides TWINT casino pour joueurs suisses.">
<link rel="icon" type="image/png" href="/favicon.png">
<style>'.$CSS.'
.ph{padding:20px 18px 10px}
.ph h1{font-size:22px;font-weight:900;margin-bottom:6px}
.ph p{font-size:13px;color:var(--gray);margin-bottom:16px}
.lst{padding:0 18px 100px;display:flex;flex-direction:column;gap:8px}
.it{background:var(--dark2);border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--white);border:1px solid var(--border)}
.it:hover{border-color:rgba(0,160,224,.3)}
.it-ico{font-size:22px;flex-shrink:0}
.it-info{flex:1}
.it-h{font-size:13px;font-weight:700;line-height:1.35;margin-bottom:2px}
.it-s{font-size:11px;color:var(--gray)}
.it-arr{color:var(--twint);font-size:17px}
</style></head><body>'.$NAV.'
<div class="content-hero" style="text-align:center;padding:36px 18px 28px">
  <div class="twint-badge"><span class="twint-logo">📱</span> Guide Officiel TWINT Casino</div>
  <h1 style="font-size:clamp(22px,5vw,42px);font-weight:900;line-height:1.15;margin-bottom:12px"><em>Casino TWINT Suisse</em></h1>
  <p style="color:var(--gray);max-width:500px;margin:0 auto;font-size:14px;line-height:1.6">Le guide complet pour jouer au casino en ligne avec TWINT depuis la Suisse. Dépôt, retrait, bonus et plus encore.</p>
</div>
<div class="twint-info">
  <div class="ti-item"><span class="ti-n">'.count($PAGES).'</span><div class="ti-l">Guides TWINT</div></div>
  <div class="ti-item"><span class="ti-n">4M+</span><div class="ti-l">Utilisateurs TWINT CH</div></div>
  <div class="ti-item"><span class="ti-n">CHF</span><div class="ti-l">Devise suisse</div></div>
  <div class="ti-item"><span class="ti-n">Instant</span><div class="ti-l">Dépôt TWINT</div></div>
  <div class="ti-item"><span class="ti-n">0%</span><div class="ti-l">Frais cachés</div></div>
</div>
<div class="trust">
  <div class="tbadge">📱 TWINT Suisse</div>
  <div class="tbadge">🏦 Toutes banques CH</div>
  <div class="tbadge">⚡ Instantané</div>
  <div class="tbadge">🔒 100% Sécurisé</div>
  <div class="tbadge">🇨🇭 Pour résidents CH</div>
</div>
<div class="ph"><h1 style="background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Tous les Guides TWINT Casino</h1><p>'.count($PAGES).' guides complets pour jouer au casino avec TWINT en Suisse</p></div>
<div class="lst">';

foreach ($PAGES as $p) {
    $listingHtml .= '<a href="/fr/twint/'.$p['slug'].'/" class="it">
      <div class="it-ico">📱</div>
      <div class="it-info">
        <div class="it-h">'.htmlspecialchars($p['h1']).'</div>
        <div class="it-s">'.htmlspecialchars($p['meta']).'</div>
      </div>
      <div class="it-arr">›</div>
    </a>';
}

$listingHtml .= '</div>'.$FOOTER.$BNAV.'</body></html>';
file_put_contents($listingDir.'/index.html', $listingHtml);
$allPages[] = 'fr/twint/';
echo "✅ /fr/twint/\n\n";

// UPDATE SITEMAP
echo "📋 UPDATING SITEMAP\n";
$sitemapFile = $BASE.'/sitemap.xml';
if (file_exists($sitemapFile)) {
    $existing = file_get_contents($sitemapFile);
    $date = date('Y-m-d');
    $newUrls = '';
    foreach ($allPages as $p) {
        $newUrls .= '<url><loc>https://hurrahcasino.ch/'.$p.'</loc><lastmod>'.$date.'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>'."\n";
    }
    $existing = str_replace('</urlset>', $newUrls.'</urlset>', $existing);
    file_put_contents($sitemapFile, $existing);
    $total = substr_count($existing, '<url>');
    echo "✅ Sitemap: ".$total." URLs\n\n";
}

echo "=== DONE ===\n";
echo "✅ ".count($PAGES)." TWINT pages générées\n";
echo "✅ /fr/twint/ listing créé\n";
echo "✅ Sitemap mis à jour\n";
echo "⚠️  rm gen_twint.php\n";
