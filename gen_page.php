<?php
/**
 * Universal Page Generator for HurrahCasino.ch
 * Usage: php gen_page.php --lang=de --path=/de/bonus/bitcoin --h1="Bitcoin Casino Schweiz" --key="bitcoin casino schweiz"
 */

$opts = getopt('', ['lang:', 'path:', 'h1:', 'key:']);
$LANG = $opts['lang'] ?? 'de';
$PATH = $opts['path'] ?? '';
$H1 = $opts['h1'] ?? '';
$KEY = $opts['key'] ?? $H1;

if(!$PATH || !$H1){
    echo "Usage: php gen_page.php --lang=de --path=/de/bonus/bitcoin --h1=\"Bitcoin Casino Schweiz\" --key=\"bitcoin casino schweiz\"\n";
    exit(1);
}

$OPENAI_KEY = 'OPENAI_KEY_HERE';
$ANTHROPIC_KEY = 'ANTHROPIC_KEY_HERE';
$BASE = '/home/admin/web/hurrahcasino.ch/public_html';
$DIR = $BASE.$PATH;
$AFF1 = 'https://track.smartlink-gh.site/sl?id=687a0b103913fc6f4740965e&pid=3935&sub1=hurrah-'.str_replace('/','-',trim($PATH,'/'));
$AFF2 = 'https://track.smartlink-gh.site/sl?id=67977ae8d54db995337cdfd9&pid=3935&sub1=hurrah-'.str_replace('/','-',trim($PATH,'/'));
$AFF3 = 'https://track.smartlink-gh.site/sl?id=67935cda9c50ac5df850a615&pid=3935&sub1=hurrah-'.str_replace('/','-',trim($PATH,'/'));

if(!is_dir($DIR)) mkdir($DIR, 0755, true);
if(!is_dir($DIR.'/images')) mkdir($DIR.'/images', 0755, true);

$IS_DE = $LANG === 'de';
$SITE_LANG = $IS_DE ? 'de' : 'fr';
$HOME = '/'.$SITE_LANG.'/';

function claude($p,$k,$t=3000){
    $d=json_encode(['model'=>'claude-sonnet-4-6','max_tokens'=>$t,'messages'=>[['role'=>'user','content'=>$p]]]);
    $ch=curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$d,CURLOPT_HTTPHEADER=>['Content-Type: application/json','x-api-key: '.$k,'anthropic-version: 2023-06-01'],CURLOPT_TIMEOUT=>120]);
    $r=json_decode(curl_exec($ch),true);curl_close($ch);
    return preg_replace('/```html|```/i','',trim($r['content'][0]['text']??''));
}

function genImg($prompt,$file,$key,$dir){
    $jpg=$dir.'/'.str_replace('.png','.jpg',$file);
    if(file_exists($jpg)) return basename($jpg);
    $d=json_encode(['model'=>'gpt-image-1','prompt'=>$prompt.', professional Swiss casino style, dark background, no text','n'=>1,'size'=>'1024x1024','output_format'=>'png']);
    $ch=curl_init('https://api.openai.com/v1/images/generations');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$d,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$key],CURLOPT_TIMEOUT=>90]);
    $r=json_decode(curl_exec($ch),true);curl_close($ch);
    if(!isset($r['data'][0]['b64_json'])) return null;
    $png=$dir.'/'.$file;
    file_put_contents($png,base64_decode($r['data'][0]['b64_json']));
    $img=imagecreatefrompng($png);imagejpeg($img,$jpg,85);imagedestroy($img);unlink($png);
    return basename($jpg);
}

echo "=== GENERATING: $H1 ===\n";
echo "Lang: $LANG | Path: $PATH\n\n";

// IMAGES
echo "📸 Generating images...\n";
$imgSlug = basename($PATH);
$heroImg = genImg("$KEY Switzerland online casino gambling", "hero-$imgSlug.png", $OPENAI_KEY, $DIR);
$authorImg = genImg($IS_DE ? 
    "Swiss German casino expert professional headshot dark background confident" :
    "Swiss French casino expert professional headshot dark background confident",
    "author-$imgSlug.png", $OPENAI_KEY, $DIR);
echo $heroImg ? "✅ Hero image\n" : "⚠️ Hero image failed\n";
echo $authorImg ? "✅ Author image\n" : "⚠️ Author image failed\n";

// CONTENT
echo "\n📝 Generating content...\n";

if($IS_DE){
    $author_name = "Anna Weber";
    $author_city = "Bern";
    $author_role = "Schweizer Casino-Expertin";

    $intro = claude("Du bist $author_name, Casino-Expertin aus $author_city, Schweiz. Schreib Einleitung 320-380 Wörter für '$H1'.\n\nThema: $KEY\nKouvre: persönliche Erfahrung, warum dieses Thema wichtig für Schweizer Spieler, CHF Vorteile, du hast 30+ Optionen getestet, TWINT und PostFinance wenn relevant.\nErste Person. Journalistisch. Konkret. Keine Markdown. Kein HTML.", $ANTHROPIC_KEY, 750);
    echo "✅ Intro\n";

    $main1 = claude("Schweizer Casino-Expertin. Schreib 500-580 Wörter ausführlichen Guide zu '$H1'.\n\nThema: $KEY\nDetails: wie es funktioniert, Vor- und Nachteile, CHF Beträge, TWINT wenn relevant, Schweizer Besonderheiten, konkrete Tipps.\nKeine Markdown. Kein HTML.", $ANTHROPIC_KEY, 1100);
    echo "✅ Main content 1\n";

    $top5 = claude("Schweizer Casino-Expertin. Schreib 450-520 Wörter: 'Top 5 Empfehlungen für $H1'\n\n1. SwissGold Casino - beste Wahl, MGA, TWINT, 200 CHF Bonus\n2. AlpinePlay - CFMJ Lizenz, 150 CHF\n3. ZürichCasino - beste Alternative, MGA\n4. HelvétiaSlots - Bonus ohne Einzahlung\n5. BernerWin - cashback Option\n\nFür jeden: warum empfohlen, spezifisch zu '$KEY', CHF, Lizenz. Kein HTML.", $ANTHROPIC_KEY, 1000);
    echo "✅ Top 5\n";

    $main2 = claude("Casino-Expertin. Schreib 380-440 Wörter: 'Worauf man bei $H1 achten sollte'\n\nKriterien:\n1. MGA oder CFMJ Lizenz\n2. CHF Währung verfügbar\n3. TWINT/PostFinance Support\n4. Schweizer Kundensupport\n5. Auszahlungsgeschwindigkeit\n6. Bonus Bedingungen\n\nMit Tipps und Warnungen. Kein HTML.", $ANTHROPIC_KEY, 850);
    echo "✅ Main content 2\n";

    $comment_text = claude("Schreib authentischen Spielerkommentar (60-80 Wörter) zu '$KEY' in der Schweiz.\nSpieler: Klaus Müller, 45, Zürich, Ingenieur. Positiv aber nuanciert. Natürliches Deutsch. Kein HTML.", $ANTHROPIC_KEY, 180);
    $comment_name = "Klaus Müller, 45 Jahre — Zürich";
    $comment_role = "Ingenieur · Casino-Spieler seit 5 Jahren";
    echo "✅ Comment\n";

    $fazit = claude("Casino-Expertin Anna. Fazit 200-240 Wörter zu '$H1'.\nZusammenfassung, Empfehlung SwissGold Casino, CTA. Erste Person. Kein HTML.", $ANTHROPIC_KEY, 450);
    echo "✅ Fazit\n";

    $faq_qs = [
        "Was ist $H1 und wie funktioniert es?",
        "Ist $H1 in der Schweiz legal?",
        "Welches ist das beste Casino für $KEY?",
        "Kann ich mit TWINT bei $KEY einzahlen?",
        "Wie hoch sind die Limits bei $KEY in CHF?",
        "Gibt es einen Bonus für $KEY?",
        "Wie lange dauert die Auszahlung bei $KEY?",
        "Welche Lizenz braucht ein Casino für $KEY?",
    ];
    $nav_items = ['Casinos'=>'/'.$LANG.'/casino/','Bonus'=>'/'.$LANG.'/bonus/','Spiele'=>'/'.$LANG.'/spiele/','Guide'=>'/'.$LANG.'/guide/'];
    $lang_alt = ['href'=>'/fr/','label'=>'🇫🇷 FR'];
    $footer_links = ['Startseite'=>'/'.$LANG.'/','Casinos'=>'/'.$LANG.'/casino/','Bonus'=>'/'.$LANG.'/bonus/','Spiele'=>'/'.$LANG.'/spiele/','Guide'=>'/'.$LANG.'/guide/','Français'=>'/fr/'];
    $nav_bottom = ['🏠 Start'=>'/'.$LANG.'/','🎰 Casinos'=>'/'.$LANG.'/casino/','🎁 Bonus'=>'/'.$LANG.'/bonus/','🎮 Spiele'=>'/'.$LANG.'/spiele/','📖 Guide'=>'/'.$LANG.'/guide/'];
    $cta_text = "Jetzt spielen →";
    $sponsored = "Gesponsert";
    $footer_disc = "ist eine Casino-Vergleichsseite. Gesponserter Inhalt. Glücksspiel kann süchtig machen. Nur für Personen ab 18 Jahren.";
    $bc_home = "Start";
    $official_links = [
        'CFMJ.ch' => 'https://www.cfmj.ch',
        'MGA Malta' => 'https://www.mga.org.mt',
        'Wikipedia' => 'https://de.wikipedia.org/wiki/Online-Casino',
    ];
    $tbl_headers = ['Casino','Bonus','Wagering','CHF','TWINT','Lizenz','Note'];
    $tbl_rows = [
        ['🏆 SwissGold','200 CHF + 100 FS','x30','✓','✓','MGA','9.4'],
        ['AlpinePlay','150 CHF + 50 FS','x25','✓','✓','CFMJ','9.1'],
        ['ZürichCasino','300 CHF','x30','✓','✗','MGA','8.9'],
        ['HelvétiaSlots','100 CHF o.E.','x40','✓','✓','MGA','8.7'],
        ['BernerWin','250 CHF + CB','x35','✓','✗','MGA','8.5'],
    ];
    $pros = ['TWINT & PostFinance verfügbar','MGA/CFMJ Lizenz','CHF Währung','Schnelle Auszahlung','DE/FR Support'];
    $cons = ['Wagering x30 zu erfüllen','Keine KSA-Lizenz','Nicht alle Casinos verfügbar','Bedingungen variieren'];
    $stat_labels = ['Getestet','CHF Min.','Ø Wagering','Lizenz'];
    $stat_values = ['30+','10 CHF','x30','MGA'];
} else {
    $author_name = "Marie Dubois";
    $author_city = "Lausanne";
    $author_role = "Experte Casino Suisse";

    $intro = claude("Tu es $author_name, experte casino à $author_city, Suisse. Écris introduction 320-380 mots pour '$H1'.\n\nSujet: $KEY\nCouvre: expérience personnelle, pourquoi important pour joueurs suisses, avantages CHF, tu as testé 30+ options, TWINT et PostFinance si pertinent.\nPremière personne. Journalistique. Concret. Pas de Markdown. Pas de HTML.", $ANTHROPIC_KEY, 750);
    echo "✅ Intro\n";

    $main1 = claude("Experte casino suisse. Écris 500-580 mots guide complet sur '$H1'.\n\nSujet: $KEY\nDétails: comment ça fonctionne, avantages et inconvénients, montants CHF, TWINT si pertinent, spécificités suisses, conseils concrets.\nPas de Markdown. Pas de HTML.", $ANTHROPIC_KEY, 1100);
    echo "✅ Main content 1\n";

    $top5 = claude("Experte casino suisse. Écris 450-520 mots: 'Top 5 Recommandations pour $H1'\n\n1. SwissGold Casino - meilleur choix, MGA, TWINT, 200 CHF\n2. AlpinePlay - licence CFMJ, 150 CHF\n3. LémanCasino - meilleure alternative, MGA\n4. HelvétiaSlots - bonus sans dépôt\n5. GenevaWin - option cashback\n\nPour chaque: pourquoi recommandé, spécifique à '$KEY', CHF, licence. Pas de HTML.", $ANTHROPIC_KEY, 1000);
    echo "✅ Top 5\n";

    $main2 = claude("Experte casino. Écris 380-440 mots: 'Ce qu\'il faut vérifier pour $H1'\n\nCritères:\n1. Licence MGA ou CFMJ\n2. CHF disponible\n3. TWINT/PostFinance\n4. Support en français\n5. Vitesse de retrait\n6. Conditions de bonus\n\nAvec conseils et avertissements. Pas de HTML.", $ANTHROPIC_KEY, 850);
    echo "✅ Main content 2\n";

    $comment_text = claude("Écris commentaire authentique joueur (60-80 mots) sur '$KEY' en Suisse.\nJoueur: Thomas Favre, 42, Genève, entrepreneur. Positif mais nuancé. Français naturel. Pas de HTML.", $ANTHROPIC_KEY, 180);
    $comment_name = "Thomas Favre, 42 ans — Genève";
    $comment_role = "Entrepreneur · Joueur de casino depuis 4 ans";
    echo "✅ Comment\n";

    $fazit = claude("Experte casino Marie. Conclusion 200-240 mots sur '$H1'.\nRésumé, recommandation SwissGold Casino, CTA. Première personne. Pas de HTML.", $ANTHROPIC_KEY, 450);
    echo "✅ Conclusion\n";

    $faq_qs = [
        "Qu'est-ce que $H1 et comment ça fonctionne?",
        "$H1 est-il légal en Suisse?",
        "Quel est le meilleur casino pour $KEY?",
        "Peut-on payer avec TWINT pour $KEY?",
        "Quelles sont les limites en CHF pour $KEY?",
        "Y a-t-il un bonus pour $KEY?",
        "Combien de temps dure le retrait pour $KEY?",
        "Quelle licence faut-il pour $KEY?",
    ];
    $nav_items = ['Casinos'=>'/'.$LANG.'/casino/','Bonus'=>'/'.$LANG.'/bonus/','Jeux'=>'/'.$LANG.'/jeux/','Guide'=>'/'.$LANG.'/guide/'];
    $lang_alt = ['href'=>'/de/','label'=>'🇩🇪 DE'];
    $footer_links = ['Accueil'=>'/'.$LANG.'/','Casinos'=>'/'.$LANG.'/casino/','Bonus'=>'/'.$LANG.'/bonus/','Jeux'=>'/'.$LANG.'/jeux/','Guides'=>'/'.$LANG.'/guide/','Deutsch'=>'/de/'];
    $nav_bottom = ['🏠 Accueil'=>'/'.$LANG.'/','🎰 Casinos'=>'/'.$LANG.'/casino/','🎁 Bonus'=>'/'.$LANG.'/bonus/','🎮 Jeux'=>'/'.$LANG.'/jeux/','📖 Guide'=>'/'.$LANG.'/guide/'];
    $cta_text = "Jouer →";
    $sponsored = "Sponsorisé";
    $footer_disc = "est un site de comparaison de casinos. Contenu sponsorisé. Le jeu peut créer une dépendance. Interdit aux moins de 18 ans.";
    $bc_home = "Accueil";
    $official_links = [
        'CFMJ.ch' => 'https://www.cfmj.ch',
        'MGA Malta' => 'https://www.mga.org.mt',
        'Wikipedia' => 'https://fr.wikipedia.org/wiki/Casino_en_ligne',
    ];
    $tbl_headers = ['Casino','Bonus','Wagering','CHF','TWINT','Licence','Note'];
    $tbl_rows = [
        ['🏆 SwissGold','200 CHF + 100 FS','x30','✓','✓','MGA','9.4'],
        ['AlpinePlay','150 CHF + 50 FS','x25','✓','✓','CFMJ','9.1'],
        ['LémanCasino','300 CHF','x30','✓','✗','MGA','8.9'],
        ['HelvétiaSlots','100 CHF s.d.','x40','✓','✓','MGA','8.7'],
        ['GenevaWin','250 CHF + CB','x35','✓','✗','MGA','8.5'],
    ];
    $pros = ['TWINT & PostFinance disponibles','Licence MGA/CFMJ','Devise CHF','Retrait rapide','Support FR/DE'];
    $cons = ['Wagering x30 à compléter','Pas de licence KSA','Conditions variables','Délais de retrait différents'];
    $stat_labels = ['Testés','CHF Min.','Ø Wagering','Licence'];
    $stat_values = ['30+','10 CHF','x30','MGA'];
}
// FAQ
$faq_items = [];
foreach($faq_qs as $q){
    $prompt = $IS_DE ?
        "2-3 Sätze Expertin: \"$q\"\nKontext: $KEY Schweiz CHF TWINT MGA. Natürliches Deutsch. Kein HTML." :
        "2-3 phrases experte: \"$q\"\nContexte: $KEY Suisse CHF TWINT MGA. Français naturel. Pas de HTML.";
    $faq_items[$q] = trim(claude($prompt, $ANTHROPIC_KEY, 130));
    echo "✅ FAQ\n";
}

$schemaFaq=['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>[]];
foreach($faq_items as $q=>$a) $schemaFaq['mainEntity'][]=['@type'=>'Question','name'=>$q,'acceptedAnswer'=>['@type'=>'Answer','text'=>$a]];
$schemaArt=['@context'=>'https://schema.org','@type'=>'Article','headline'=>$H1,'author'=>['@type'=>'Person','name'=>$author_name],'datePublished'=>date('Y-m-d'),'dateModified'=>date('Y-m-d'),'publisher'=>['@type'=>'Organization','name'=>'HurrahCasino.ch']];

$faqHtml='';
foreach($faq_items as $q=>$a){
    $faqHtml.='<div class="faq-item"><div class="fq">'.htmlspecialchars($q).'<span class="fi">+</span></div><div class="fa">'.htmlspecialchars($a).'</div></div>';
}

// Get CSS from main page
$main_css_file = $BASE.'/'.$LANG.'/index.html';
$main_content = file_exists($main_css_file) ? file_get_contents($main_css_file) : '';
preg_match('/<style>(.*?)<\/style>/s', $main_content, $m);
$css = $m[1] ?? '';

$extra_css = '
body{padding-bottom:70px}
@media(min-width:768px){body{padding-bottom:0}}
.content-hero{background:linear-gradient(160deg,#0d0000,#080808);padding:28px 20px 20px;border-bottom:1px solid var(--border);position:relative;z-index:1}
.breadcrumb{display:flex;gap:6px;align-items:center;margin-bottom:12px;flex-wrap:wrap}
.breadcrumb a{color:var(--gray);font-size:12px;text-decoration:none}
.breadcrumb span{color:var(--gray);font-size:12px}
.hero-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(212,0,0,.12);border:1px solid rgba(212,0,0,.25);color:#ff6666;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-bottom:12px}
.content-hero h1{font-size:clamp(22px,5vw,38px);font-weight:900;line-height:1.2;margin-bottom:10px;background:linear-gradient(135deg,#fff,#ddd);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.content-hero h1 em{font-style:normal;background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero-desc{font-size:13px;color:rgba(255,255,255,.6);line-height:1.65;max-width:600px;margin-bottom:16px}
.hero-btns{display:flex;gap:10px;flex-wrap:wrap}
.btn-primary{background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:11px 22px;border-radius:10px;font-weight:800;font-size:13px;text-decoration:none;box-shadow:0 6px 20px rgba(212,0,0,.35);display:inline-block}
.btn-secondary{border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8);padding:11px 18px;border-radius:10px;font-weight:600;font-size:13px;text-decoration:none;display:inline-block}
.stats-bar{display:flex;overflow-x:auto;gap:0;background:var(--dark2);border-bottom:1px solid var(--border);scrollbar-width:none}
.stats-bar::-webkit-scrollbar{display:none}
.stat-item{flex:1;min-width:90px;padding:12px 14px;text-align:center;border-right:1px solid var(--border)}
.stat-num{font-size:18px;font-weight:900;background:linear-gradient(135deg,var(--red),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;display:block}
.stat-lbl{font-size:10px;color:var(--gray);margin-top:2px;font-weight:500}
.section{padding:20px;position:relative;z-index:1}
@media(min-width:768px){.section{max-width:1100px;margin:0 auto;padding:28px 40px}}
.content-body{font-size:13px;line-height:1.8;color:rgba(255,255,255,.85)}
.content-body h2{font-size:clamp(15px,3vw,20px);font-weight:800;margin:24px 0 10px;color:#fff;border-left:3px solid var(--red);padding-left:10px;line-height:1.3}
.content-body h3{font-size:15px;font-weight:700;margin:16px 0 8px;color:var(--red2)}
.content-body p{margin-bottom:12px}
.content-body ul,.content-body ol{margin:0 0 12px 18px}
.content-body li{margin-bottom:6px}
.content-body strong{color:#fff}
.content-body a{color:var(--red2);font-weight:600;text-decoration:none}
.content-body a:hover{text-decoration:underline}
.hero-img{width:100%;height:240px;object-fit:cover;display:block;border-bottom:1px solid var(--border)}
@media(min-width:768px){.hero-img{height:360px}}
.tbl-wrap{overflow-x:auto;margin:16px 0;-webkit-overflow-scrolling:touch;border-radius:10px;border:1px solid var(--border)}
.main-tbl{width:100%;border-collapse:collapse;font-size:12px;min-width:480px;background:var(--dark2)}
.main-tbl thead tr{background:linear-gradient(135deg,var(--red),#8B0000)}
.main-tbl th{padding:10px 12px;color:#fff;font-size:11px;font-weight:700;text-align:left;letter-spacing:.5px;text-transform:uppercase;white-space:nowrap}
.main-tbl td{padding:10px 12px;border-bottom:1px solid rgba(255,255,255,.06);color:rgba(255,255,255,.8);vertical-align:middle}
.main-tbl tr:last-child td{border-bottom:none}
.main-tbl tr:hover td{background:rgba(255,255,255,.03)}
.main-tbl tr.top-row td{background:rgba(212,0,0,.08);font-weight:600}
.chk{color:#4ade80;font-weight:700}
.crs{color:var(--red2);font-weight:700}
.author-box{background:var(--dark2);border:1px solid var(--border);border-radius:14px;padding:18px;display:flex;gap:14px;align-items:flex-start;margin:24px 0}
.author-img{width:72px;height:72px;border-radius:50%;object-fit:cover;flex-shrink:0;border:3px solid var(--red)}
.author-name{font-size:15px;font-weight:700;color:#fff;margin-bottom:2px}
.author-role{font-size:12px;color:var(--red2);font-weight:600;margin-bottom:6px}
.author-bio{font-size:12px;color:rgba(255,255,255,.6);line-height:1.6}
.comment-box{background:var(--dark2);border:1px solid var(--border);border-left:3px solid var(--gold);border-radius:0 10px 10px 0;padding:16px 18px;margin:20px 0}
.comment-text{font-size:13px;color:rgba(255,255,255,.8);line-height:1.7;font-style:italic;margin-bottom:10px}
.comment-author{display:flex;align-items:center;gap:10px}
.comment-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--red),var(--gold));display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.comment-name{font-size:12px;font-weight:700;color:#fff}
.comment-role-txt{font-size:11px;color:var(--gray)}
.official-link{display:inline-flex;align-items:center;gap:5px;background:rgba(212,0,0,.06);border:1px solid rgba(212,0,0,.2);border-radius:6px;padding:5px 10px;font-size:12px;color:var(--red2);text-decoration:none;margin:3px}
.official-link:hover{background:rgba(212,0,0,.12)}
.info-box{background:rgba(212,0,0,.06);border:1px solid rgba(212,0,0,.2);border-left:3px solid var(--red);border-radius:0 10px 10px 0;padding:14px 16px;margin:16px 0}
.info-box-label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--red2);margin-bottom:5px}
.info-box p{font-size:13px;color:rgba(255,255,255,.75);margin:0;line-height:1.6}
.pros-cons{display:grid;grid-template-columns:1fr;gap:10px;margin:16px 0}
@media(min-width:560px){.pros-cons{grid-template-columns:1fr 1fr}}
.pros-box{background:rgba(39,174,96,.06);border:1px solid rgba(39,174,96,.2);border-radius:12px;padding:16px}
.cons-box{background:rgba(212,0,0,.06);border:1px solid rgba(212,0,0,.2);border-radius:12px;padding:16px}
.pc-title{font-size:13px;font-weight:700;margin-bottom:10px}
.pros-box .pc-title{color:#4ade80}
.cons-box .pc-title{color:var(--red2)}
.pc-list{list-style:none}
.pc-list li{font-size:12px;color:rgba(255,255,255,.75);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05);display:flex;gap:6px;line-height:1.5}
.pc-list li:last-child{border-bottom:none}
.cta-section{margin:24px 20px;background:linear-gradient(135deg,#1a0000,#0d0000);border:1px solid rgba(212,0,0,.2);border-radius:16px;padding:22px 18px;text-align:center;position:relative;z-index:1}
@media(min-width:768px){.cta-section{max-width:1020px;margin:24px auto}}
.cta-title{font-size:19px;font-weight:900;margin-bottom:4px}
.cta-title span{background:linear-gradient(135deg,var(--red),var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.cta-sub{font-size:12px;color:var(--gray);margin-bottom:14px;line-height:1.5}
.cta-btn{display:inline-block;background:linear-gradient(135deg,var(--red),var(--red2));color:#fff;padding:12px 26px;border-radius:10px;font-weight:800;font-size:14px;text-decoration:none;box-shadow:0 6px 20px rgba(212,0,0,.4)}
.cta-sponsored{font-size:10px;color:var(--gray);margin-top:6px;display:block}
.faq-item{background:var(--dark2);border-radius:11px;margin-bottom:8px;overflow:hidden;border:1px solid var(--border)}
.fq{padding:13px 16px;font-size:13px;font-weight:600;display:flex;justify-content:space-between;align-items:center;cursor:pointer;line-height:1.4;color:#fff}
.fi{color:var(--red2);font-size:18px;transition:.2s;flex-shrink:0;margin-left:8px}
.faq-item.open .fi{transform:rotate(45deg)}
.fa{font-size:12px;color:var(--gray);line-height:1.65;max-height:0;overflow:hidden;transition:max-height .3s,padding .3s;padding:0 16px}
.faq-item.open .fa{max-height:300px;padding:0 16px 14px}
.rel-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:14px 0}
@media(min-width:480px){.rel-grid{grid-template-columns:repeat(3,1fr)}}
.rel-card{background:var(--dark2);border-radius:10px;padding:10px;border:1px solid var(--border);display:block;font-size:12px;font-weight:700;text-decoration:none;color:var(--white);line-height:1.4;transition:border-color .2s}
.rel-card:hover{border-color:var(--border2)}
.rel-sub{font-size:11px;color:var(--gray);margin-top:3px}
.sec-eyebrow{display:inline-block;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--red2);margin-bottom:8px}
.sec-title{font-size:clamp(17px,3vw,24px);font-weight:800;line-height:1.25;margin-bottom:14px}
.sec-title span{background:linear-gradient(135deg,var(--red),var(--red2));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
';

// Build breadcrumb path
$path_parts = explode('/', trim($PATH, '/'));
$bc = '<a href="/'.$LANG.'/">'.$bc_home.'</a>';
$bc_path = '';
foreach($path_parts as $i => $part){
    if($i === count($path_parts)-1){
        $bc .= '<span>›</span><span>'.htmlspecialchars($H1).'</span>';
    } else {
        $bc_path .= '/'.$part;
        $bc .= '<span>›</span><a href="'.$bc_path.'/">'.ucfirst($part).'</a>';
    }
}

// Nav items HTML
$nav_html = '';
foreach($nav_items as $label=>$href){
    $nav_html .= '<a href="'.$href.'">'.$label.'</a>';
}
$nav_html .= '<a href="'.$lang_alt['href'].'">'.$lang_alt['label'].'</a>';

// Footer links
$footer_html = '';
foreach($footer_links as $label=>$href){
    $footer_html .= '<a href="'.$href.'">'.$label.'</a>';
}

// Bottom nav
$bn_html = '';
foreach($nav_bottom as $label=>$href){
    $active = (strpos($PATH, explode(' ',$label)[1] ?? '') !== false) ? ' active' : '';
    $bn_html .= '<a href="'.$href.'" class="bn-item'.$active.'"><span class="bn-ico">'.explode(' ',$label)[0].'</span>'.trim(str_replace(explode(' ',$label)[0],'',$label)).'</a>';
}

// Table HTML
$tbl_head = implode('', array_map(fn($h) => '<th>'.$h.'</th>', $tbl_headers));
$tbl_body = '';
foreach($tbl_rows as $i => $row){
    $cls = $i===0 ? ' class="top-row"' : '';
    $cells = implode('', array_map(fn($c) => '<td>'.($c==='✓'?'<span class="chk">✓</span>':($c==='✗'?'<span class="crs">✗</span>':htmlspecialchars($c))).'</td>', $row));
    $tbl_body .= '<tr'.$cls.'>'.$cells.'</tr>';
}

// Official links
$off_links = '';
foreach($official_links as $label=>$href){
    $off_links .= '<a href="'.$href.'" target="_blank" rel="noopener" class="official-link">🔗 '.$label.'</a>';
}

// Pros/cons
$pros_html = implode('', array_map(fn($p) => '<li><span style="color:#4ade80">✓</span>'.$p.'</li>', $pros));
$cons_html = implode('', array_map(fn($c) => '<li><span style="color:var(--red2)">✗</span>'.$c.'</li>', $cons));

// Stats
$stats_html = '';
for($i=0;$i<count($stat_labels);$i++){
    $border = $i < count($stat_labels)-1 ? '' : '';
    $stats_html .= '<div class="stat-item"><span class="stat-num">'.$stat_values[$i].'</span><div class="stat-lbl">'.$stat_labels[$i].'</div></div>';
}

$hero_img_tag = $heroImg ? '<img src="'.basename($heroImg).'" alt="'.htmlspecialchars($H1).'" class="hero-img" loading="eager">' : '';
$author_img_tag = $authorImg ? '<img src="'.basename($authorImg).'" alt="'.htmlspecialchars($author_name).'" class="author-img">' : '<div class="author-img" style="background:linear-gradient(135deg,var(--red),var(--gold));display:flex;align-items:center;justify-content:center;font-size:28px">👩</div>';

$title_meta = $H1.' — '.($IS_DE ? 'Guide & Empfehlungen' : 'Guide & Recommandations').' '.date('Y').' | HurrahCasino.ch';
$desc_meta = $IS_DE ?
    $H1.': vollständiger Leitfaden für Schweizer Spieler. Top 5 getestet, CHF Beträge, TWINT verfügbar. Experten-Bewertung von HurrahCasino.ch.' :
    $H1.': guide complet pour joueurs suisses. Top 5 testés, montants CHF, TWINT disponible. Évaluation experte par HurrahCasino.ch.';
echo "\n📄 Building HTML...\n";

$html = '<!DOCTYPE html>
<html lang="'.$SITE_LANG.'">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#080808">
<title>'.htmlspecialchars($title_meta).'</title>
<meta name="description" content="'.htmlspecialchars($desc_meta).'">
<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1">
<meta property="og:type" content="article">
<meta property="og:title" content="'.htmlspecialchars($H1).'">
<meta property="og:description" content="'.htmlspecialchars($desc_meta).'">
<meta property="og:locale" content="'.($IS_DE ? 'de_CH' : 'fr_CH').'">
<meta property="og:site_name" content="HurrahCasino.ch">
<link rel="canonical" href="https://hurrahcasino.ch'.$PATH.'/">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="apple-touch-icon" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">
<script type="application/ld+json">'.json_encode($schemaFaq,JSON_UNESCAPED_UNICODE).'</script>
<script type="application/ld+json">'.json_encode($schemaArt,JSON_UNESCAPED_UNICODE).'</script>
<style>'.$css.$extra_css.'</style>
</head>
<body>

<nav class="topbar">
  <a href="'.$HOME.'" class="logo">
    <div class="logo-icon">🎰</div>
    <div class="logo-text">Hurrah<span>Casino</span></div>
  </a>
  <div class="nav-desktop">'.$nav_html.'</div>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="topbar-cta">
    '.$cta_text.'<span class="sponsored-label">'.$sponsored.'</span>
  </a>
</nav>
<div class="swiss-divider"></div>

'.$hero_img_tag.'

<div class="content-hero">
  <div class="breadcrumb">'.$bc.'</div>
  <div class="hero-badge">🏆 30+ '.($IS_DE ? 'Optionen getestet' : 'Options testées').'</div>
  <h1>'.htmlspecialchars($H1).'</h1>
  <p class="hero-desc">'.htmlspecialchars(substr($intro, 0, 200)).'</p>
  <div class="hero-btns">
    <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="btn-primary">
      🎰 '.($IS_DE ? 'Jetzt spielen' : 'Jouer maintenant').' →
    </a>
    <a href="#guide" class="btn-secondary">
      '.($IS_DE ? 'Zum Guide ↓' : 'Voir le guide ↓').'
    </a>
  </div>
</div>

<div class="stats-bar">'.$stats_html.'</div>

<div class="section">
<div class="content-body">
<p>'.nl2br(htmlspecialchars($intro)).'</p>

<div class="info-box">
  <div class="info-box-label">💡 '.htmlspecialchars($H1).' — '.($IS_DE ? 'Kurzübersicht' : 'En bref').'</div>
  <p>'.($IS_DE ? '<strong>Offizielle Quellen:</strong> ' : '<strong>Sources officielles:</strong> ').$off_links.'</p>
</div>

<h2 id="guide">'.htmlspecialchars($H1).' — '.($IS_DE ? 'Vollständiger Guide' : 'Guide Complet').'</h2>
<p>'.nl2br(htmlspecialchars($main1)).'</p>

<h2>'.($IS_DE ? 'Top 5 Empfehlungen' : 'Top 5 Recommandations').' — '.htmlspecialchars($H1).'</h2>
<p>'.nl2br(htmlspecialchars($top5)).'</p>
</div>

<div class="tbl-wrap">
<table class="main-tbl">
  <thead><tr>'.$tbl_head.'</tr></thead>
  <tbody>'.$tbl_body.'</tbody>
</table>
</div>

<div class="content-body">
<h2>'.($IS_DE ? 'Worauf man achten sollte' : 'Ce qu\'il faut vérifier').' — '.htmlspecialchars($H1).'</h2>
<p>'.nl2br(htmlspecialchars($main2)).'</p>
</div>

<div class="comment-box">
  <div class="comment-text">"'.htmlspecialchars($comment_text).'"</div>
  <div class="comment-author">
    <div class="comment-avatar">👤</div>
    <div>
      <div class="comment-name">'.htmlspecialchars($comment_name).'</div>
      <div class="comment-role-txt">'.htmlspecialchars($comment_role).'</div>
    </div>
  </div>
</div>

<div class="content-body">
<h2>'.($IS_DE ? 'Vor- und Nachteile' : 'Avantages et Inconvénients').' — '.htmlspecialchars($H1).'</h2>
</div>

<div class="pros-cons">
  <div class="pros-box">
    <div class="pc-title">✓ '.($IS_DE ? 'Vorteile' : 'Avantages').'</div>
    <ul class="pc-list">'.$pros_html.'</ul>
  </div>
  <div class="cons-box">
    <div class="pc-title">✗ '.($IS_DE ? 'Nachteile' : 'Inconvénients').'</div>
    <ul class="pc-list">'.$cons_html.'</ul>
  </div>
</div>
</div>

<div class="cta-section">
  <div class="cta-title">🎰 <span>'.htmlspecialchars($H1).'</span></div>
  <div class="cta-sub">'.($IS_DE ? 'Gesponsert · 18+ · Verantwortungsvoll spielen' : 'Sponsorisé · 18+ · Jouez de manière responsable').'</div>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="cta-btn">
    '.($IS_DE ? '200 CHF Bonus holen →' : 'Réclamer 200 CHF →').'
  </a>
  <span class="cta-sponsored">⚠️ '.($IS_DE ? 'Gesponserte Link — Glücksspiel nur für 18+' : 'Lien sponsorisé — jeux réservés aux 18+').'</span>
</div>

<div class="section">

<div class="author-box">
  '.$author_img_tag.'
  <div>
    <div class="author-name">'.htmlspecialchars($author_name).'</div>
    <div class="author-role">'.htmlspecialchars($author_role).' · HurrahCasino.ch</div>
    <p class="author-bio">'.($IS_DE ?
      $author_name.' ist eine unabhängige Casino-Expertin mit über 10 Jahren Erfahrung im Schweizer Glücksspielmarkt. Sie hat 200+ Online-Casinos getestet und spezialisiert sich auf CHF-Zahlungen und TWINT-Integration.' :
      $author_name.' est une experte casino indépendante avec plus de 10 ans d\'expérience sur le marché suisse. Elle a testé 200+ casinos en ligne et se spécialise dans les paiements CHF et l\'intégration TWINT.').'</p>
  </div>
</div>

<div class="sec-eyebrow">'.($IS_DE ? 'Häufige Fragen' : 'Questions Fréquentes').'</div>
<h2 class="sec-title">FAQ — <span>'.htmlspecialchars($H1).'</span></h2>
<div class="content-body">
'.$faqHtml.'
</div>

<div class="content-body">
<h2>'.($IS_DE ? 'Fazit' : 'Conclusion').' — '.htmlspecialchars($H1).'</h2>
<p>'.nl2br(htmlspecialchars($fazit)).'</p>
</div>

<div class="sec-eyebrow" style="margin-top:24px">'.($IS_DE ? 'Ähnliche Themen' : 'Sujets Similaires').'</div>
<h2 class="sec-title">'.($IS_DE ? 'Weitere' : 'Autres').' <span>'.($IS_DE ? 'Guides' : 'Guides').'</span></h2>
<div class="rel-grid">
  <a href="'.$HOME.'casino/" class="rel-card">🎰 '.($IS_DE ? 'Beste Casinos' : 'Meilleurs Casinos').'<div class="rel-sub">Top '.($IS_DE ? 'Schweizer' : 'Suisses').'</div></a>
  <a href="'.$HOME.'bonus/" class="rel-card">🎁 Bonus<div class="rel-sub">CHF '.($IS_DE ? 'Angebote' : 'Offres').'</div></a>
  <a href="'.$HOME.($IS_DE ? 'twint' : 'twint').'/casino-twint/" class="rel-card">📱 TWINT<div class="rel-sub">'.($IS_DE ? 'Zahlungen' : 'Paiements').'</div></a>
  <a href="'.$HOME.($IS_DE ? 'spiele' : 'jeux').'/" class="rel-card">🎮 '.($IS_DE ? 'Spiele' : 'Jeux').'<div class="rel-sub">2000+ '.($IS_DE ? 'Spiele' : 'Jeux').'</div></a>
  <a href="'.$HOME.'guide/" class="rel-card">📖 Guide<div class="rel-sub">'.($IS_DE ? 'Tipps & Tricks' : 'Conseils').'</div></a>
  <a href="'.($IS_DE ? '/fr/' : '/de/').'" class="rel-card">'.($IS_DE ? '🇫🇷 FR' : '🇩🇪 DE').'<div class="rel-sub">'.($IS_DE ? 'Suisse Romande' : 'Deutschschweiz').'</div></a>
</div>
</div>

<footer class="footer">
  <div class="footer-logo">Hurrah<span>Casino</span>.ch</div>
  <div class="footer-links">'.$footer_html.'</div>
  <p class="footer-disclaimer">HurrahCasino.ch '.$footer_disc.' © '.date('Y').' HurrahCasino.ch</p>
</footer>

<nav class="bottom-nav">'.$bn_html.'</nav>

<script>
document.querySelectorAll(".fq").forEach(q=>q.addEventListener("click",()=>q.closest(".faq-item").classList.toggle("open")));
document.querySelectorAll("a[href^=\"#\"]").forEach(a=>{
  a.addEventListener("click",e=>{
    var t=document.querySelector(a.getAttribute("href"));
    if(t){e.preventDefault();var top=t.getBoundingClientRect().top+window.pageYOffset-70;window.scrollTo({top:top,behavior:"smooth"});}
  });
});
</script>
</body>
</html>';
file_put_contents($DIR.'/index.html', $html);

// Update sitemap
$sitemap_file = $BASE.'/sitemap.xml';
if(file_exists($sitemap_file)){
    $sitemap = file_get_contents($sitemap_file);
    $url = 'https://hurrahcasino.ch'.$PATH.'/';
    if(strpos($sitemap, $url) === false){
        $new_url = '<url><loc>'.$url.'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
        $sitemap = str_replace('</urlset>', $new_url."\n</urlset>", $sitemap);
        file_put_contents($sitemap_file, $sitemap);
        echo "✅ Added to sitemap\n";
    } else {
        // Update lastmod
        $sitemap = preg_replace(
            '#(<loc>'.preg_quote($url,'#').'</loc>\s*<lastmod>)[^<]*(</lastmod>)#',
            '${1}'.date('Y-m-d').'${2}',
            $sitemap
        );
        file_put_contents($sitemap_file, $sitemap);
        echo "✅ Updated sitemap lastmod\n";
    }
}

// robots.txt check
$robots = $BASE.'/robots.txt';
if(!file_exists($robots)){
    file_put_contents($robots, "User-agent: *\nAllow: /\nSitemap: https://hurrahcasino.ch/sitemap.xml\n");
}

echo "\n=== DONE ===\n";
echo "✅ ".$H1."\n";
echo "✅ Path: https://hurrahcasino.ch".$PATH."/\n";
echo "Words: ";
echo shell_exec('cat '.$DIR.'/index.html | sed \'s/<[^>]*>//g\' | wc -w');
echo "⚠️  rm gen_page.php after use\n";
