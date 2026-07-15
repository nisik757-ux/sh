<?php
/**
 * TWINT Casino Pages Generator DE for hurrahcasino.ch
 * 30 unique pages targeting Swiss TWINT casino queries in German
 */

$OPENAI_KEY = 'OPENAI_KEY_HERE';
$ANTHROPIC_KEY = 'ANTHROPIC_KEY_HERE';

$BASE = '/home/admin/web/hurrahcasino.ch/public_html';
$IMG_DIR = $BASE . '/images/de';

$AFF = [
    'https://track.smartlink-gh.site/sl?id=687a0b103913fc6f4740965e&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67977ae8d54db995337cdfd9&pid=3935',
    'https://track.smartlink-gh.site/sl?id=67935cda9c50ac5df850a615&pid=3935',
];

if (!is_dir($BASE.'/de/twint')) mkdir($BASE.'/de/twint', 0755, true);
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
    if (file_exists($jpg)) return '/images/de/'.basename($jpg);
    $data = json_encode(['model'=>'gpt-image-1','prompt'=>$prompt.', professional Swiss casino website luxury, no text','n'=>1,'size'=>'1024x1024','output_format'=>'png']);
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
    return '/images/de/'.basename($jpg);
}

function faqHtml($qs) {
    $h='';
    foreach($qs as $q=>$a) $h.='<div class="faq-item"><div class="fq">'.htmlspecialchars($q).' <span class="fi">+</span></div><div class="fa">'.$a.'</div></div>';
    return $h;
}

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
.cta-top{background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:8px 16px;border-radius:10px;font-size:12px;font-weight:800;text-decoration:none;white-space:nowrap}
.sponsored-label{font-size:9px;font-weight:400;opacity:.7;display:block;text-align:center}
.content-hero{background:linear-gradient(160deg,#001020,#080808);padding:34px 18px 22px;border-bottom:1px solid var(--border)}
.bc{display:flex;gap:6px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
.bc a{color:var(--gray);font-size:11px;text-decoration:none}.bc a:hover{color:var(--twint)}
.bc span{color:var(--gray);font-size:11px}
.content-hero h1{font-size:clamp(19px,4vw,34px);font-weight:900;line-height:1.22;margin-bottom:8px}
.content-hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.content-hero p{font-size:13px;color:var(--gray);line-height:1.65}
.cta-box{margin:16px 18px 0;background:linear-gradient(135deg,#001A2E,#000D1A);border:1px solid rgba(0,160,224,.2);border-radius:18px;padding:22px 18px;text-align:center}
.cta-title{font-size:19px;font-weight:900;margin-bottom:4px}
.cta-title span{background:linear-gradient(135deg,var(--twint),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.cta-sub{font-size:12px;color:var(--gray);margin-bottom:14px;line-height:1.5}
.cta-btn{display:inline-block;background:linear-gradient(135deg,var(--twint),#0078A8);color:#fff;padding:13px 28px;border-radius:11px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 8px 24px rgba(0,160,224,.3)}
.cta-sponsored{font-size:10px;color:var(--gray);margin-top:6px;display:block}
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
.ti-bar{display:flex;overflow-x:auto;gap:0;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.ti-bar::-webkit-scrollbar{display:none}
.ti-item{flex:1;min-width:100px;padding:13px 10px;text-align:center;border-right:1px solid var(--border)}
.ti-n{font-size:17px;font-weight:900;color:var(--twint);display:block}
.ti-l{font-size:10px;color:var(--gray);margin-top:2px}
';

$NAV = '<nav class="topbar"><a href="/de/" class="logo"><div class="logo-icon">🎰</div><div class="logo-text">Hurrah<span>Casino</span></div></a><div class="nav-links"><a href="/de/casino/">Casinos</a><a href="/de/bonus/">Bonus</a><a href="/de/twint/" style="color:var(--twint)">TWINT</a><a href="/de/spiele/">Spiele</a><a href="/fr/">🇫🇷 FR</a></div><a href="'.$AFF[0].'" target="_blank" rel="noopener sponsored" class="cta-top">Spielen →<span class="sponsored-label">Gesponsert</span></a></nav>';
$BNAV = '<nav class="bnav"><a href="/de/" class="bn"><span class="bn-i">🏠</span>Start</a><a href="/de/casino/" class="bn"><span class="bn-i">🎰</span>Casinos</a><a href="/de/bonus/" class="bn"><span class="bn-i">🎁</span>Bonus</a><a href="/de/twint/" class="bn on"><span class="bn-i">📱</span>TWINT</a><a href="/de/guide/" class="bn"><span class="bn-i">📖</span>Guide</a></nav>';
$FOOTER = '<footer class="footer"><div class="footer-logo">Hurrah<span>Casino</span>.ch</div><div class="footer-links"><a href="/de/">Start</a><a href="/de/casino/">Casinos</a><a href="/de/bonus/">Bonus</a><a href="/de/twint/">TWINT</a><a href="/de/guide/">Guides</a><a href="/fr/">Français</a></div><p class="footer-disc">HurrahCasino.ch ist eine Casino-Vergleichswebsite. Gesponserter Inhalt. Glücksspiel kann süchtig machen. Nur ab 18 Jahren. © '.date('Y').' HurrahCasino.ch</p></footer>';

function buildPage($h1, $meta, $bc, $intro, $body, $faqHtml, $relHtml, $aff, $img) {
    global $NAV, $BNAV, $FOOTER, $CSS;
    $imgTag = $img ? '<img src="'.$img.'" alt="'.htmlspecialchars($h1).'" style="width:100%;height:220px;object-fit:cover;display:block">' : '';
    return '<!DOCTYPE html><html lang="de"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#080808"><title>'.htmlspecialchars($h1).' | HurrahCasino.ch</title><meta name="description" content="'.htmlspecialchars($meta).'"><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'</style></head><body>'.$NAV.$imgTag.'<div class="content-hero"><div class="bc">'.$bc.'</div><h1><em>'.htmlspecialchars($h1).'</em></h1><p>'.$intro.'</p></div><div class="cta-box"><div class="cta-title">📱 <span>TWINT Casino Schweiz</span></div><div class="cta-sub">Gesponserter Inhalt · Verantwortungsvoll spielen · Nur ab 18</div><a href="'.$aff.'" target="_blank" rel="noopener sponsored" class="cta-btn">Mit TWINT Spielen →</a><span class="cta-sponsored">Gesponserter Link — verantwortungsvoll spielen</span></div><div class="content-body">'.$body.'</div><div style="padding:0 18px 18px"><div style="font-size:16px;font-weight:900;margin-bottom:12px">❓ Häufige Fragen zu TWINT Casino</div>'.$faqHtml.'</div><div style="padding:0 18px 18px"><div style="font-size:16px;font-weight:900;margin-bottom:12px">📱 Weitere TWINT Guides</div><div class="rel-grid">'.$relHtml.'</div></div>'.$FOOTER.$BNAV.'<script>document.querySelectorAll(".fq").forEach(q=>q.addEventListener("click",()=>q.closest(".faq-item").classList.toggle("open")));</script></body></html>';
}

// 30 DE TWINT PAGES
$PAGES = [
['slug'=>'casino-twint','h1'=>'Casino TWINT Schweiz — Mit der Schweizer Zahlungs-App Spielen','meta'=>'Casino online TWINT Schweiz. Einzahlung und Auszahlung via TWINT. Die beliebteste Schweizer Zahlungs-App für Online Casinos. Vollständiger Leitfaden.','angle'=>'TWINT ist DIE Schweizer Zahlungs-App schlechthin — über 4 Millionen Schweizer nutzen sie täglich. Erkläre warum TWINT perfekt für Online Casinos ist: sofort, sicher, keine versteckten Gebühren, auf jedem Schweizer Smartphone verfügbar. Kontext: TWINT 2016 in der Schweiz gegründet, Partnerschaft mit allen großen Schweizer Banken.','img'=>'TWINT casino Switzerland blue white Swiss payment app casino mobile luxury German','steps'=>true],

['slug'=>'casino-mit-twint-einzahlen','h1'=>'Casino mit TWINT Einzahlen Schweiz — Schritt für Schritt Anleitung','meta'=>'Wie man im Casino online mit TWINT einzahlt in der Schweiz. Einfache Schritte, sofort, sicher. Praktischer Leitfaden für Schweizer TWINT Nutzer.','angle'=>'Praktischer Leitfaden für die erste Casino-Einzahlung via TWINT in der Schweiz. Konkrete Schritte: TWINT App öffnen, Betrag wählen, QR-Code des Casinos scannen oder Telefonnummer verwenden, sofortige Bestätigung. Häufige Fehler und wie man sie vermeidet. Mindesteinzahlung in CHF.','img'=>'TWINT casino deposit Switzerland step guide QR code scan mobile German','steps'=>true],

['slug'=>'casino-twint-auszahlung','h1'=>'Casino TWINT Auszahlung Schweiz — Gewinne Schnell Empfangen','meta'=>'Wie man Casino-Gewinne auf TWINT in der Schweiz auszahlt. Echte Laufzeiten, Limits, Lösungen bei Problemen. Vollständiger TWINT Auszahlungsleitfaden.','angle'=>'Die TWINT Casino-Auszahlung ist die Hauptsorge Schweizer Spieler. Erkläre den genauen Ablauf: Auszahlungsantrag, Identitätsprüfung falls erforderlich, echte Laufzeiten (kein Marketing), TWINT-Limits für Auszahlungen, was tun wenn Auszahlung blockiert. Vergleich TWINT vs Banküberweisung vs Karte Geschwindigkeit.','img'=>'TWINT withdrawal casino Switzerland fast receive money Swiss blue German','steps'=>true],

['slug'=>'casino-twint-bonus','h1'=>'Casino TWINT Bonus Schweiz — Exklusive Angebote für TWINT Nutzer','meta'=>'Casino Boni exklusiv für TWINT Einzahlungen in der Schweiz. Freispiele, Willkommensbonus, Cashback TWINT. Beste Angebote für Schweizer TWINT Spieler.','angle'=>'Manche Casinos bieten SPEZIELLE Boni für TWINT-Einzahlungen an. Erkläre warum, welche Casinos exklusive TWINT-Promotionen haben, wie man sie aktiviert, und wie man seinen Wert maximiert wenn man mit TWINT aus der Schweiz spielt.','img'=>'TWINT bonus casino Switzerland exclusive offer gift golden blue Swiss German','steps'=>false],

['slug'=>'casino-twint-ohne-einzahlung','h1'=>'Casino TWINT Ohne Einzahlung Schweiz — Gratis Bonus mit TWINT','meta'=>'Casino Bonus ohne Einzahlung mit TWINT in der Schweiz. Kostenlos spielen und mit TWINT auszahlen. Verifizierte Angebote für Schweizer Spieler.','angle'=>'No-Deposit-Bonus MIT TWINT für Auszahlung kombinieren. Erkläre wie man einen Gratis-Bonus bekommt, spielt, gewinnt, und direkt auf TWINT auszahlt ohne jemals eine Kreditkarte zu benutzen. Die sicherste Strategie für neue Schweizer Spieler.','img'=>'TWINT no deposit bonus casino Switzerland free play Swiss mobile blue German','steps'=>false],

['slug'=>'casinos-mit-twint','h1'=>'Casinos die TWINT Akzeptieren Schweiz — Vollständige Geprüfte Liste','meta'=>'Vollständige Liste der Online Casinos die TWINT in der Schweiz akzeptieren. Geprüft, sicher, mit Bonus verfügbar. Leitfaden für die beste TWINT Casino Wahl.','angle'=>'Leitfaden für Casinos die WIRKLICH TWINT akzeptieren (nicht alle tun es). Auswahlkriterien: TWINT für Ein- UND Auszahlung verfügbar, anerkannte Lizenz, CHF Bonus, Deutschen Support. Warum manche Casinos TWINT noch nicht akzeptieren und die Alternativen.','img'=>'Casino TWINT accepted list Switzerland verified secure blue Swiss luxury German','steps'=>false],

['slug'=>'twint-casino-willkommensbonus','h1'=>'Willkommensbonus Casino TWINT Schweiz — Verdoppeln Sie Ihre Erste Einzahlung','meta'=>'Willkommensbonus Casino mit TWINT in der Schweiz. 100% bis 200% auf Ihre erste TWINT Einzahlung. Vollständiger Leitfaden zur Bonusmaximierung mit TWINT.','angle'=>'Willkommensbonus via TWINT aktiviert. Erkläre ob der Bonus je nach Zahlungsmethode variiert, wie man den echten Bonuswert in CHF mit TWINT berechnet, Umsatzbedingungen angepasst an den Schweizer Markt, und welches Casino den besten Willkommensbonus für TWINT Nutzer bietet.','img'=>'Welcome bonus TWINT casino Switzerland 200 percent CHF blue gold luxury German','steps'=>false],

['slug'=>'twint-casino-freispiele','h1'=>'Freispiele Casino TWINT Schweiz — Gratis Spins für TWINT Einzahlungen','meta'=>'Freispiele für TWINT Einzahlungen Casino Schweiz. 50 bis 500 Gratis-Spins bei Einzahlung mit TWINT. Beste Freispiele TWINT Angebote Schweiz.','angle'=>'Mit TWINT verknüpfte Freispiele. Welche Casinos bieten Gratis-Spins speziell für TWINT-Einzahlungen an, wie aktiviert man sie, welche Slots sind berechtigt, und die echten Bedingungen für die Auszahlung der Freispielgewinne auf TWINT.','img'=>'Free spins TWINT casino Switzerland golden reels blue Swiss mobile German','steps'=>false],

['slug'=>'twint-casino-sicherheit','h1'=>'TWINT Casino Sicherheit Schweiz — Die Sicherste Zahlungsmethode','meta'=>'Sicherheit Casino TWINT Schweiz. Warum TWINT sicherer als Kreditkarte für Casino ist. Datenschutz, Authentifizierung, Garantien von Postfinance und UBS.','angle'=>'TWINT wird von den großen Schweizer Banken (PostFinance, UBS, ZKB usw.) unterstützt. Erkläre warum es die sicherste Methode für Casino in der Schweiz ist: integrierte Zwei-Faktor-Authentifizierung, keine Bankdaten geteilt, Schweizer Bankkundenschutz, sofortige Betrugsmeldung.','img'=>'TWINT security casino Switzerland safe bank protection Swiss blue official German','steps'=>false],

['slug'=>'twint-casino-limits','h1'=>'TWINT Casino Limits Schweiz — Obergrenzen und Wie Man Sie Erhöht','meta'=>'TWINT Limits für Casino in der Schweiz. Tages- und Monatslimits, wie man sie erhöht. Leitfaden für Schweizer Spieler die mehr einzahlen möchten.','angle'=>'TWINT-Limits können große Schweizer Spieler blockieren. Erkläre die Standard-TWINT-Limits (500 CHF/Transaktion, 3000 CHF/Monat), wie man sie über die Banking-App erhöht, und Alternativen für größere Einzahlungen wenn TWINT nicht ausreicht.','img'=>'TWINT limits casino Switzerland increase cap Swiss banking blue luxury German','steps'=>false],

['slug'=>'twint-casino-mobil','h1'=>'Mobiles Casino TWINT Schweiz — Spielen auf iPhone und Android mit TWINT','meta'=>'Mobiles Casino TWINT Schweiz. Auf dem Smartphone mit TWINT spielen. Casino Apps kompatibel mit TWINT für iOS und Android. Mobiler TWINT Casino Leitfaden.','angle'=>'TWINT ist eine mobile App — das natürliche Erlebnis für Schweizer Smartphone-Spieler. Leitfaden für das mobile Casino-Erlebnis mit TWINT: wie es auf iPhone (iOS) und Android funktioniert, beste Casino-Apps für die Schweiz mit TWINT-Integration, und warum die Kombination mobil + TWINT ideal ist.','img'=>'TWINT mobile casino Switzerland iPhone Android app Swiss blue luxury German','steps'=>false],

['slug'=>'twint-casino-zuerich','h1'=>'Casino TWINT Zürich — Mit der Schweizer App aus der Wirtschaftshauptstadt Spielen','meta'=>'Casino TWINT aus Zürich. Leitfaden für Zürcher Spieler die TWINT nutzen. Zweisprachige Casinos DE/FR, CHF Bonus, TWINT App Zürich.','angle'=>'Leitfaden für Zürcher Spieler die TWINT nutzen. Zürich ist die Wirtschaftshauptstadt der Schweiz und TWINT ist allgegenwärtig. Erkläre wie zweisprachige Zürcher DE/FR TWINT für Casinos nutzen, Zürcher Banken kompatibel mit TWINT, und die besten Casinos aus Zürich.','img'=>'TWINT casino Zurich Switzerland economic capital blue luxury skyline German','steps'=>false],

['slug'=>'twint-casino-bern','h1'=>'Casino TWINT Bern — Mit TWINT aus der Schweizer Hauptstadt Spielen','meta'=>'Casino TWINT aus Bern. Leitfaden für Berner Spieler. TWINT Bundeshauptstadt, zweisprachige Casinos DE/FR, CHF Bonus aus Bern.','angle'=>'Leitfaden für Berner Spieler die TWINT nutzen. Bern ist zweisprachig DE/FR und die Bundeshauptstadt. TWINT-Banken in Bern (Berner Kantonalbank, PostFinance Hauptsitz), Casinos mit deutschem und französischem Support, und das Casino-Erlebnis aus der politischen Hauptstadt der Schweiz.','img'=>'TWINT casino Bern Switzerland capital bilingual blue luxury German French','steps'=>false],

['slug'=>'twint-casino-basel','h1'=>'Casino TWINT Basel — Spielen am Dreiländereck mit TWINT','meta'=>'Casino TWINT Basel Schweiz. Leitfaden für Basler Spieler. TWINT am Dreiländereck CH/DE/FR, CHF und EUR Casinos, bestes Casino für Basel.','angle'=>'Basel liegt am Dreiländereck CH/DE/FR — Basler Spieler haben Zugang zu Casinos in drei Ländern. Leitfaden: Vor- und Nachteile Schweizer vs deutsche Casinos mit TWINT, CHF und EUR Optionen, und warum Schweizer Casinos mit TWINT für Basler oft die beste Wahl sind.','img'=>'TWINT casino Basel Switzerland tripoint border blue luxury German French Rhine','steps'=>false],

['slug'=>'twint-postfinance-casino','h1'=>'Casino TWINT PostFinance Schweiz — Die Postbank für Online Casinos','meta'=>'Casino TWINT PostFinance Schweiz. TWINT mit PostFinance Konto für Casino nutzen. Leitfaden für PostFinance Kunden die online spielen möchten.','angle'=>'PostFinance ist eine der größten Schweizer Banken und ein TWINT-Hauptpartner. Spezifischer Leitfaden für PostFinance-Kunden die TWINT für Casinos nutzen: TWINT auf PostFinance aktivieren, PostFinance-spezifische Limits, und wie man das Casino-Erlebnis mit PostFinance + TWINT optimiert.','img'=>'TWINT PostFinance casino Switzerland post bank yellow blue Swiss luxury German','steps'=>false],

['slug'=>'twint-ubs-casino','h1'=>'Casino TWINT UBS Schweiz — Mit der Größten Schweizer Bank Spielen','meta'=>'Casino TWINT UBS Schweiz. TWINT mit UBS Konto für Online Casino nutzen. Leitfaden für UBS Kunden. Sicher und sofort mit UBS Key4 und TWINT.','angle'=>'UBS ist die größte Schweizer Bank und ihre Kunden haben Zugang zu TWINT. Leitfaden für UBS-Kunden die TWINT für Casinos nutzen: TWINT-Aktivierung in der UBS Key4 App, UBS-Limits, zusätzliche UBS-Sicherheit und wie man optimal mit einem UBS-Konto Casino spielt.','img'=>'TWINT UBS casino Switzerland biggest bank blue red luxury Swiss premium German','steps'=>false],

['slug'=>'twint-raiffeisen-casino','h1'=>'Casino TWINT Raiffeisen Schweiz — Die Genossenschaftsbank für Spieler','meta'=>'Casino TWINT Raiffeisen Schweiz. TWINT mit Raiffeisen Konto für Casino. Leitfaden für Raiffeisen Kunden. In allen Schweizer Regionen verfügbar.','angle'=>'Raiffeisen ist stark in ländlichen Schweizer Regionen vertreten und ihre Kunden nutzen TWINT. Leitfaden für Raiffeisen-Kunden die TWINT für Casinos nutzen: Aktivierung in der Raiffeisen App, nationale Präsenz (auch in ländlichen Gebieten), und wie man auch aus abgelegenen Schweizer Regionen auf Online Casinos zugreift.','img'=>'TWINT Raiffeisen casino Switzerland cooperative bank blue regional Swiss German','steps'=>false],

['slug'=>'twint-zkb-casino','h1'=>'Casino TWINT ZKB Schweiz — Zürcher Kantonalbank und Online Casino','meta'=>'Casino TWINT ZKB (Zürcher Kantonalbank) Schweiz. Leitfaden für ZKB Kunden für Online Casino mit TWINT. Kantonalbank Zürich und verantwortungsvolles Spielen.','angle'=>'ZKB ist die größte Kantonalbank der Schweiz. Leitfaden für ZKB-Kunden die TWINT für Casinos nutzen: ZKB-Spezifikationen, TWINT in der ZKB App verfügbar, Fokus auf Spieler aus der Zürcher Region und Umgebung.','img'=>'TWINT ZKB casino Switzerland cantonal bank Zurich blue luxury Swiss German','steps'=>false],

['slug'=>'twint-casino-aviator','h1'=>'Aviator mit TWINT Schweiz Spielen — Das Crash Game mit Schweizer App','meta'=>'Aviator Casino TWINT Schweiz. Aviator Crash Game mit TWINT Einzahlung spielen. Strategien Aviator + TWINT Leitfaden für Schweizer Spieler.','angle'=>'Aviator ist das beliebteste Crash Game in der Schweiz und TWINT ist die bevorzugte Einzahlungsmethode. Spezifischer Leitfaden Aviator + TWINT: TWINT Einzahlung für Aviator, empfohlene CHF Beträge, Cashout-Strategien angepasst an das Schweizer Budget mit TWINT, und die besten Casinos für Aviator + TWINT.','img'=>'Aviator crash game TWINT Switzerland airplane multiplier blue mobile Swiss German','steps'=>false],

['slug'=>'twint-casino-blackjack','h1'=>'Blackjack Casino TWINT Schweiz — Strategie und Einzahlung via TWINT','meta'=>'Blackjack Casino TWINT Schweiz. Blackjack mit TWINT Einzahlung spielen. Grundstrategie + TWINT Leitfaden für Schweizer Blackjack Spieler.','angle'=>'Blackjack mit TWINT in der Schweiz: die ideale Kombination für analytische Schweizer Spieler. Praktischer Leitfaden: mit TWINT für Blackjack einzahlen, optimale CHF Beträge, Grundstrategie erklärt, und Casinos mit Live Blackjack die TWINT akzeptieren.','img'=>'Blackjack TWINT casino Switzerland cards strategy blue Swiss luxury German','steps'=>false],

['slug'=>'twint-casino-slots','h1'=>'Casino Slots TWINT Schweiz — Spielautomaten mit TWINT Spielen','meta'=>'Slots Casino TWINT Schweiz. Spielautomaten mit TWINT Einzahlung spielen. Gates of Olympus, Sweet Bonanza mit TWINT. Slots TWINT Leitfaden Schweiz.','angle'=>'Slots sind die beliebtesten Spiele und TWINT die bevorzugte Schweizer Zahlungsmethode. Praktischer Leitfaden Slots + TWINT: welche Slots man mit CHF TWINT Budget wählt, optimaler RTP, wie Freispiele bei TWINT Einzahlungen aktiviert werden, und die besten Spielautomaten in Schweizer TWINT Casinos.','img'=>'Slots casino TWINT Switzerland gaming machines golden blue Swiss luxury German','steps'=>false],

['slug'=>'twint-casino-live','h1'=>'Live Casino TWINT Schweiz — Echte Dealer mit TWINT Einzahlung','meta'=>'Live Casino TWINT Schweiz. Mit echten Dealern spielen und via TWINT einzahlen. Baccarat, Roulette, Blackjack live + TWINT für Schweizer Spieler.','angle'=>'Das Live Casino mit TWINT: das authentischste Casino-Erlebnis von zu Hause aus in der Schweiz. Leitfaden: welche Live Casinos TWINT akzeptieren, erforderliche Internetverbindung (10 Mbps+ empfohlen), deutschsprachige Dealer verfügbar, Mindesteinsätze in CHF und wie TWINT das Nachladen während einer Live-Session vereinfacht.','img'=>'Live casino TWINT Switzerland real dealer stream blue Swiss luxury German','steps'=>false],

['slug'=>'twint-casino-bonus-20-chf','h1'=>'20 CHF Casino Bonus Ohne Einzahlung TWINT Schweiz — Exklusives Angebot','meta'=>'20 CHF Bonus ohne Einzahlung Casino TWINT Schweiz. Exklusives Angebot für neue Schweizer Spieler. Auszahlung via TWINT. Leitfaden 20 CHF TWINT.','angle'=>'Der 20 CHF No-Deposit Bonus ist sehr gefragt bei Schweizern (erscheint in Google-Suchen). Spezifischer Leitfaden: wo man einen echten 20 CHF Bonus ohne Einzahlung in der Schweiz findet, wie man ihn auf TWINT auszahlt, echte Bedingungen, und warum dieser Betrag in der Schweiz besonders beliebt ist.','img'=>'20 CHF bonus casino TWINT Switzerland no deposit Swiss franc blue gift German','steps'=>false],

['slug'=>'twint-casino-bonus-10-chf','h1'=>'10 CHF Casino Bonus Ohne Einzahlung TWINT Schweiz — Mit 10 CHF Starten','meta'=>'10 CHF Bonus ohne Einzahlung Casino TWINT Schweiz. Ideal zum Einstieg ohne Risiko. Gewinne auf TWINT auszahlen. Leitfaden 10 CHF Bonus Schweiz.','angle'=>'Der 10 CHF No-Deposit Bonus: der ideale Einstieg um Casino in der Schweiz zu entdecken. Leitfaden: wo man einen echten 10 CHF Bonus findet, realistische Umsatzbedingungen, Auszahlung auf TWINT, und ob 10 CHF wirklich ausreicht um ein Casino zu testen. Vergleich 10 CHF vs 20 CHF Bonus.','img'=>'10 CHF bonus casino TWINT Switzerland no deposit Swiss franc blue small German','steps'=>false],

['slug'=>'twint-casino-registrierung','h1'=>'Casino TWINT Registrierung Schweiz — Schritt für Schritt Anmeldung','meta'=>'Wie man sich bei einem Casino mit TWINT in der Schweiz registriert. Erforderliche Dokumente, Verifizierung, TWINT aktivieren. Registrierungsleitfaden TWINT Casino Schweiz.','angle'=>'Vollständiger Registrierungsleitfaden für ein Schweizer Casino mit TWINT. Schritte: richtiges Casino wählen, Formular mit Schweizer Daten ausfüllen, Identitätsverifizierung (Schweizer Ausweis oder Reisepass), TWINT mit Casino-Konto verknüpfen, erste Einzahlung tätigen. Gesamtdauer des Prozesses.','img'=>'Casino registration TWINT Switzerland sign up steps blue Swiss guide German','steps'=>true],

['slug'=>'twint-casino-faq','h1'=>'FAQ Casino TWINT Schweiz — Alle Antworten auf Ihre TWINT Fragen','meta'=>'Häufige Fragen Casino TWINT Schweiz. Kann man mit TWINT einzahlen? TWINT Auszahlung? TWINT Bonus? Limits? Alle Antworten für Schweizer Spieler.','angle'=>'Vollständige FAQ zu TWINT und Casinos in der Schweiz. Die 15 häufigsten Fragen Schweizer zu TWINT Casino: Limits, Sicherheit, kompatible Banken, Laufzeiten, Boni, Auszahlung, Verifizierung. Präzise und praktische Antworten. Q&A Format um alle TWINT Casino Suchen abzudecken.','img'=>'FAQ casino TWINT Switzerland answers questions Swiss blue guide comprehensive German','steps'=>false],

['slug'=>'twint-vs-kreditkarte-casino','h1'=>'TWINT vs Kreditkarte Casino Schweiz — Was Ist Besser zum Spielen?','meta'=>'TWINT vs Kreditkarte für Casino in der Schweiz. Gebühren, Geschwindigkeit, Sicherheit, Limits. Welche Zahlungsmethode für Schweizer Casino Spieler besser ist.','angle'=>'Ehrlicher und detaillierter Vergleich TWINT vs Kreditkarte für Schweizer Casinos. Vergleichstabelle: Einzahlungsgeschwindigkeit, Auszahlungsgeschwindigkeit, Gebühren, Sicherheit, Limit, Anonymität, Verfügbarkeit in Casinos. Endurteil: für welches Profil Schweizer Spieler TWINT besser als die Kreditkarte ist.','img'=>'TWINT vs credit card casino Switzerland comparison blue versus Swiss German','steps'=>false],

['slug'=>'twint-vs-bankueberweisung-casino','h1'=>'TWINT vs Banküberweisung Casino Schweiz — Der Definitive Vergleich','meta'=>'TWINT vs Banküberweisung Casino Schweiz. Schnelligkeit, Gebühren, Limits. Warum TWINT für die meisten Schweizer Spieler die Banküberweisung übertrifft.','angle'=>'Vergleich TWINT vs Banküberweisung (E-Banking Schweiz) für das Casino. Kernpunkte: TWINT sofort vs Überweisung 1-3 Werktage, TWINT App vs E-Banking, Limits TWINT (3000 CHF/Monat) vs Überweisung (unbegrenzt), Gebühren verglichen. Für welchen Schweizer Spieler die Banküberweisung TWINT vorzuziehen ist.','img'=>'TWINT vs bank transfer casino Switzerland speed comparison Swiss blue luxury German','steps'=>false],

['slug'=>'twint-vs-krypto-casino','h1'=>'TWINT oder Krypto Casino Schweiz — Zwei Zahlungsrevolutionen im Vergleich','meta'=>'TWINT vs Krypto Casino Schweiz. Vor- und Nachteile jeder Methode. Für welches Profil Schweizer Spieler TWINT oder Bitcoin besser ist.','angle'=>'Die Schweiz ist bekannt für TWINT (lokale Zahlung) UND das Crypto Valley in Zug. Vergleich TWINT vs Krypto (Bitcoin/USDT) für Casino: TWINT = einfach und Schweizer, Krypto = anonym und ohne Limits. Für welchen Schweizer Spieler jede Option optimal ist. Kann man beide kombinieren?','img'=>'TWINT crypto casino Switzerland comparison two methods blue gold German Zug','steps'=>false],

['slug'=>'twint-casino-anleitung-anfaenger','h1'=>'TWINT Casino Anfänger Leitfaden Schweiz — Alles was Sie Wissen Müssen','meta'=>'TWINT Casino Leitfaden für Anfänger in der Schweiz. Wie man TWINT für Online Casinos nutzt. Erste Einzahlung, erstes Spiel, erste Auszahlung. Alles erklärt.','angle'=>'Freundlicher und beruhigender Leitfaden für Schweizer die NOCH NIE online Casino gespielt haben und mit TWINT beginnen möchten. Beginnt mit: "Wenn Sie dies lesen, sind Sie dabei Ihre erste Online-Casino-Erfahrung aus der Schweiz zu machen". Erklärt alles von Null: TWINT aktivieren, Casino wählen, erste 10 CHF Einzahlung, zuerst Demo-Slots spielen, Gewinne auszahlen.','img'=>'Beginner guide TWINT casino Switzerland first time easy Swiss blue luxury German','steps'=>true],
];

$allPages = [];
$pc = 0;

echo "=== DE TWINT CASINO PAGES GENERATOR ===\n";
echo count($PAGES)." Seiten zu generieren\n\n";

foreach ($PAGES as $page) {
    $pc++;
    $dir = $BASE.'/de/twint/'.$page['slug'];
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    echo "[".$pc."/".count($PAGES)."] ".$page['h1']."\n";

    $imgPath = genImg($page['img'], $page['slug'].'-de.png', $OPENAI_KEY, $IMG_DIR);
    echo "  🖼️ ".($imgPath ? "✅" : "❌")."\n";

    $intro = claude(
        "Schweizer Casino-Experte spezialisiert auf TWINT. 2-3 PRÄGNANTE Werbetextsätze für: \"".$page['h1']."\"\n".
        "Fokus: ".$page['angle']."\n".
        "Diese Sätze müssen TWINT spezifisch erwähnen, die Schweiz, und sofort einen Schweizer Spieler ansprechen. Sehr werbewirksam. Natürliches Schweizerdeutsch. NUR 2-3 Sätze. Auf Deutsch.",
        $ANTHROPIC_KEY, 200
    );

    $bodyPrompt = "Schweizer Casino-Experte. EINZIGARTIGER und VOLLSTÄNDIGER Artikel auf Deutsch: \"".$page['h1']."\"\n\n".
        "Pflichtfokus: ".$page['angle']."\n\n".
        "Präziser Schweizer Kontext:\n".
        "- TWINT: Schweizer App, 4+ Millionen Nutzer, Partner der großen CH Banken\n".
        "- Markt: CHF (Schweizer Franken), Premium-Spieler, anspruchsvoll\n".
        "- TWINT Limits: 500 CHF/Transaktion, 3000 CHF/Monat (erhöhbar)\n".
        "- TWINT Bankpartner: UBS, PostFinance, Raiffeisen, ZKB, BCV usw.\n".
        "- Casino-Regulierung: CFMJ (Eidgenössische Spielbankenkommission)\n\n";

    if ($page['steps']) {
        $bodyPrompt .= "Der Artikel muss enthalten:\n1. Einleitung TWINT + Casino Schweiz Kontext\n2. <h2> Schritt-für-Schritt Abschnitt (mit <div class=\"steps\"> und <div class=\"step\"><div class=\"snum\">N</div><div class=\"stxt\"><strong>Schrittitel</strong>Beschreibung</div></div>)\n3. <h2> Spezifische Vorteile\n4. <h2> Praktische Tipps\n5. <h2> Fazit mit Aufruf zur Aktion\n\n";
    } else {
        $bodyPrompt .= "Der Artikel muss haben:\n4 <h2> Abschnitte mit <p> Absätzen\n\n";
    }

    $bodyPrompt .= "800-1000 Wörter. Konkrete CHF Daten. Echte Beispiele. Werbewirksam aber nicht aufdringlich. Kein Jahr im Text. Nur HTML.";

    $body = claude($bodyPrompt, $ANTHROPIC_KEY, 1800);

    $faqPrompt = "4 sehr spezifische FAQ Fragen zu TWINT und Casino in der Schweiz für: \"".$page['h1']."\"\n".
        "Die Fragen müssen DAS SEIN WAS SCHWEIZER WIRKLICH AUF GOOGLE SUCHEN (spezifisch, praktisch, nicht generisch).\n".
        "Format: f1|||f2|||f3|||f4. NUR die 4 Fragen durch ||| getrennt, nichts anderes. Auf Deutsch.";
    $faqRaw = claude($faqPrompt, $ANTHROPIC_KEY, 200);
    $questions = explode('|||', $faqRaw);

    $faqData = [];
    foreach ($questions as $q) {
        $q = trim($q);
        if (empty($q)) continue;
        $ans = claude(
            "2 präzise und praktische Sätze: \"".$q."\" für Schweizer Spieler die TWINT nutzen. ".
            "Konkrete Antwort mit CHF wenn relevant. Natürliches Deutsch.",
            $ANTHROPIC_KEY, 120
        );
        $faqData[$q] = $ans;
    }

    $relHtml = '';
    foreach (array_slice($PAGES, 0, 8) as $rp) {
        if ($rp['slug'] === $page['slug']) continue;
        $relHtml .= '<a href="/de/twint/'.$rp['slug'].'/" class="rel-card">'.htmlspecialchars($rp['h1']).'<div class="rel-sub">TWINT Casino Schweiz 🇨🇭</div></a>';
        if (substr_count($relHtml, 'rel-card') >= 4) break;
    }

    $bc = '<a href="/de/">Start</a><span>›</span><a href="/de/bonus/">Bonus</a><span>›</span><a href="/de/twint/">TWINT</a><span>›</span><span>'.htmlspecialchars($page['slug']).'</span>';
    $html = buildPage($page['h1'], $page['meta'], $bc, $intro, $body, faqHtml($faqData), $relHtml, $AFF[$pc % 3], $imgPath);
    file_put_contents($dir.'/index.html', $html);
    $allPages[] = 'de/twint/'.$page['slug'].'/';
    echo "  ✅ /de/twint/".$page['slug']."/\n";
    sleep(1);
}

// LISTING PAGE DE
echo "\n📋 DE TWINT LISTING\n";
$listHtml = '<!DOCTYPE html><html lang="de"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><title>Casino TWINT Schweiz — Vollständiger Leitfaden | HurrahCasino.ch</title><meta name="description" content="Vollständiger TWINT Casino Leitfaden für die Schweiz. Einzahlung, Auszahlung, Boni, kompatible Banken. '.count($PAGES).'+ TWINT Casino Leitfäden."><link rel="icon" type="image/png" href="/favicon.png"><style>'.$CSS.'
.ph{padding:20px 18px 10px}.ph h1{font-size:22px;font-weight:900;margin-bottom:6px}.ph p{font-size:13px;color:var(--gray);margin-bottom:16px}
.lst{padding:0 18px 100px;display:flex;flex-direction:column;gap:8px}
.it{background:var(--dark2);border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--white);border:1px solid var(--border)}
.it:hover{border-color:rgba(0,160,224,.3)}.it-ico{font-size:22px;flex-shrink:0}.it-info{flex:1}
.it-h{font-size:13px;font-weight:700;line-height:1.35;margin-bottom:2px}.it-s{font-size:11px;color:var(--gray)}.it-arr{color:var(--twint);font-size:17px}
</style></head><body>'.$NAV.'
<div class="content-hero" style="text-align:center;padding:36px 18px 28px">
  <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(0,160,224,.12);border:1px solid rgba(0,160,224,.3);color:#00C8FF;padding:6px 16px;border-radius:20px;font-size:12px;font-weight:700;margin-bottom:18px">📱 Offizieller TWINT Casino Leitfaden</div>
  <h1 style="font-size:clamp(22px,5vw,42px);font-weight:900;line-height:1.15;margin-bottom:12px"><em style="font-style:normal;background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Casino TWINT Schweiz</em></h1>
  <p style="color:var(--gray);max-width:500px;margin:0 auto;font-size:14px;line-height:1.6">Der vollständige Leitfaden zum Online-Casino-Spielen mit TWINT in der Schweiz. Einzahlung, Auszahlung, Boni und mehr.</p>
</div>
<div class="ti-bar">
  <div class="ti-item"><span class="ti-n">'.count($PAGES).'</span><div class="ti-l">TWINT Guides</div></div>
  <div class="ti-item"><span class="ti-n">4M+</span><div class="ti-l">TWINT Nutzer CH</div></div>
  <div class="ti-item"><span class="ti-n">CHF</span><div class="ti-l">Schweizer Währung</div></div>
  <div class="ti-item"><span class="ti-n">Sofort</span><div class="ti-l">TWINT Einzahlung</div></div>
  <div class="ti-item"><span class="ti-n">0%</span><div class="ti-l">Versteckte Gebühren</div></div>
</div>
<div class="ph"><h1 style="background:linear-gradient(135deg,var(--twint),#00C8FF);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Alle TWINT Casino Leitfäden</h1><p>'.count($PAGES).' vollständige Leitfäden zum Casino-Spielen mit TWINT in der Schweiz</p></div>
<div class="lst">';

foreach ($PAGES as $p) {
    $listHtml .= '<a href="/de/twint/'.$p['slug'].'/" class="it"><div class="it-ico">📱</div><div class="it-info"><div class="it-h">'.htmlspecialchars($p['h1']).'</div><div class="it-s">'.htmlspecialchars($p['meta']).'</div></div><div class="it-arr">›</div></a>';
}

$listHtml .= '</div>'.$FOOTER.$BNAV.'</body></html>';
file_put_contents($BASE.'/de/twint/index.html', $listHtml);
$allPages[] = 'de/twint/';
echo "✅ /de/twint/\n\n";

// UPDATE SITEMAP
echo "📋 SITEMAP UPDATE\n";
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
echo "✅ ".count($PAGES)." DE TWINT Seiten generiert\n";
echo "✅ /de/twint/ Listing erstellt\n";
echo "✅ Sitemap aktualisiert\n";
echo "⚠️  rm gen_twint_de.php\n";
