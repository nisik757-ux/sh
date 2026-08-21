<?php
$OPENAI_KEY = 'OPENAI_KEY_HERE';
$ANTHROPIC_KEY = 'ANTHROPIC_KEY_HERE';
$BASE = '/home/admin/web/hurrahcasino.ch/public_html';
$AFF1 = 'https://track.smartlink-gh.site/sl?id=687a0b103913fc6f4740965e&pid=3935&sub1=hurrah-main-1';
$AFF2 = 'https://track.smartlink-gh.site/sl?id=67977ae8d54db995337cdfd9&pid=3935&sub1=hurrah-main-2';
$AFF3 = 'https://track.smartlink-gh.site/sl?id=67935cda9c50ac5df850a615&pid=3935&sub1=hurrah-main-3';

function claude($p,$k,$t=2500){
    $d=json_encode(['model'=>'claude-sonnet-4-6','max_tokens'=>$t,'messages'=>[['role'=>'user','content'=>$p]]]);
    $ch=curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$d,CURLOPT_HTTPHEADER=>['Content-Type: application/json','x-api-key: '.$k,'anthropic-version: 2023-06-01'],CURLOPT_TIMEOUT=>120]);
    $r=json_decode(curl_exec($ch),true);curl_close($ch);
    return preg_replace('/```html|```/i','',trim($r['content'][0]['text']??''));
}

echo "=== HURRAHCASINO.CH MAIN PAGE ===\n\n";
echo "📝 FR Content...\n";

$fr_intro = claude("Expert casino suisse. Écris une introduction de 350-400 mots pour la page principale de Hurrah Casino.\n\nHurrah Casino est le meilleur guide casino en ligne pour la Suisse. Couvre:\n- Ce qu'est Hurrah Casino (guide indépendant)\n- Pourquoi faire confiance à Hurrah Casino\n- 3 ans d'expérience, 200+ casinos testés\n- Couvre Suisse romande ET Suisse alémanique\n- Bonus CHF, free spins, casino sans dépôt\n- Licences CFMJ et MGA\n\nPremière personne pluriel (nous). Ton journalistique. Pas de HTML.", $ANTHROPIC_KEY, 700);
echo "✅ FR intro\n";

$fr_top = claude("Expert casino suisse. Écris 500-600 mots: 'Hurrah Casino — Notre Top 5 des Meilleurs Casinos Suisses'\n\nCritères:\n- Licence valide CFMJ ou MGA\n- Bonus en CHF\n- Support français\n- Paiements suisses TWINT PostFinance\n- RTP élevé\n\nTop 5:\n1. SwissGold Casino - 200 CHF + 100 FS, MGA\n2. AlpinePlay - 150 CHF + 50 FS, CFMJ\n3. LémanCasino - 300 CHF, meilleur live\n4. HelvétiaSlots - 100 CHF sans dépôt\n5. GenevaWin - 250 CHF + cashback\n\nJournalistique. CHF. Pas de HTML.", $ANTHROPIC_KEY, 1000);
echo "✅ FR top5\n";

$fr_about = claude("Expert casino suisse. Écris 400-450 mots: 'Qu'est-ce que Hurrah Casino?'\n\nDétails:\n- Site comparaison indépendant créé 2021\n- Équipe 8 experts casino suisses\n- 200+ casinos testés\n- Méthodologie: bonus, RTP, support, paiements\n- Couvre FR et DE Suisse\n- Partenariats affiliés transparents\n\nCrédible et professionnel. Pas de HTML.", $ANTHROPIC_KEY, 800);
echo "✅ FR about\n";

$fr_bonus = claude("Expert casino suisse. Écris 400-450 mots: 'Hurrah Casino — Guide des Bonus Suisses'\n\nCouvre:\n1. Bonus bienvenue CHF\n2. Free spins sans dépôt\n3. Cashback hebdomadaire\n4. Programme VIP\n5. Wagering exemple: 100 CHF bonus x30 = 3000 CHF\n6. Conseils maximiser bonus\n\nCHF, exemples concrets. Pas de HTML.", $ANTHROPIC_KEY, 800);
echo "✅ FR bonus\n";

$fr_pays = claude("Expert casino suisse. Écris 350-400 mots: 'Méthodes de Paiement — Hurrah Casino'\n\nMéthodes Suisse:\n- TWINT\n- PostFinance\n- Visa/Mastercard\n- PayPal\n- Paysafecard\n- Virement bancaire\n- Crypto Bitcoin Ethereum\n\nDélais et limites. Pas de HTML.", $ANTHROPIC_KEY, 700);
echo "✅ FR paiement\n";

$fr_concl = claude("Expert casino suisse. Conclusion 200-250 mots Hurrah Casino. Résumé + recommandation + CTA. Pas de HTML.", $ANTHROPIC_KEY, 400);
echo "✅ FR conclusion\n";

echo "\n📝 DE Content...\n";

$de_intro = claude("Schweizer Casino-Experte. Schreib Einleitung 350-400 Wörter für Hurrah Casino Hauptseite.\n\nHurrah Casino ist der beste Casino-Ratgeber für die Schweiz:\n- Was ist Hurrah Casino\n- Warum vertrauen\n- 3 Jahre, 200+ getestete Casinos\n- Deutschschweiz UND Romandie\n- CHF Boni, Free Spins\n- CFMJ und MGA Lizenzen\n\nErste Person Plural. Journalistisch. Kein HTML.", $ANTHROPIC_KEY, 700);
echo "✅ DE intro\n";

$de_top = claude("Schweizer Casino-Experte. Schreib 500-600 Wörter: 'Hurrah Casino — Top 5 beste Schweizer Online Casinos'\n\nKriterien:\n- Gültige Lizenz CFMJ oder MGA\n- CHF Bonus\n- Deutscher Support\n- Schweizer Zahlungen TWINT PostFinance\n- Hoher RTP\n\nTop 5:\n1. SwissGold - 200 CHF + 100 FS, MGA\n2. AlpinePlay - 150 CHF + 50 FS, CFMJ\n3. ZürichCasino - 300 CHF, bestes Live\n4. HelvétiaSlots - 100 CHF ohne Einzahlung\n5. BernerWin - 250 CHF + Cashback\n\nJournalistisch. CHF. Kein HTML.", $ANTHROPIC_KEY, 1000);
echo "✅ DE top5\n";

$de_about = claude("Schweizer Casino-Experte. Schreib 400-450 Wörter: 'Was ist Hurrah Casino?'\n\nDetails:\n- Unabhängige Vergleichsseite seit 2021\n- 8 Schweizer Casino-Experten\n- 200+ getestete Casinos\n- Testmethodik: Boni, RTP, Support, Zahlungen\n- DE und FR Schweiz\n- Transparente Affiliate-Partnerschaften\n\nGlaubwürdig. Kein HTML.", $ANTHROPIC_KEY, 800);
echo "✅ DE about\n";

$de_bonus = claude("Schweizer Casino-Experte. Schreib 400-450 Wörter: 'Hurrah Casino — Leitfaden Schweizer Casino-Boni'\n\n1. Willkommensbonus CHF\n2. Free Spins ohne Einzahlung\n3. Wöchentlicher Cashback\n4. VIP-Programm\n5. Umsatzbedingungen: 100 CHF x30 = 3000 CHF\n6. Tipps Bonus-Optimierung\n\nCHF, konkrete Beispiele. Kein HTML.", $ANTHROPIC_KEY, 800);
echo "✅ DE bonus\n";

$de_zahlung = claude("Schweizer Casino-Experte. Schreib 350-400 Wörter: 'Zahlungsmethoden — Hurrah Casino'\n\nSchweizer Methoden:\n- TWINT\n- PostFinance\n- Visa/Mastercard\n- PayPal\n- Paysafecard\n- Banküberweisung\n- Krypto Bitcoin Ethereum\n\nLaufzeiten und Limits. Kein HTML.", $ANTHROPIC_KEY, 700);
echo "✅ DE zahlung\n";

$de_concl = claude("Schweizer Casino-Experte. Fazit 200-250 Wörter Hurrah Casino. Zusammenfassung + Empfehlung + CTA. Kein HTML.", $ANTHROPIC_KEY, 400);
echo "✅ DE conclusion\n";

$faq_fr=[];
$faq_de=[];
$faq_qs_fr=["Qu'est-ce que Hurrah Casino?","Hurrah Casino est-il légal en Suisse?","Quels sont les meilleurs casinos selon Hurrah Casino?","Comment Hurrah Casino teste-t-il les casinos?","Hurrah Casino propose-t-il des bonus exclusifs?","Puis-je jouer en CHF sur les casinos recommandés?"];
$faq_qs_de=["Was ist Hurrah Casino?","Ist Hurrah Casino in der Schweiz legal?","Welche sind die besten Casinos laut Hurrah Casino?","Wie testet Hurrah Casino die Casinos?","Bietet Hurrah Casino exklusive Boni an?","Kann ich CHF bei empfohlenen Casinos spielen?"];
foreach($faq_qs_fr as $q){$a=claude("2-3 phrases expert: \"$q\"\nContexte: Hurrah Casino guide suisse. Français naturel. Pas de HTML.",$ANTHROPIC_KEY,120);$faq_fr[$q]=trim($a);echo "✅ FAQ FR\n";}
foreach($faq_qs_de as $q){$a=claude("2-3 Sätze: \"$q\"\nKontext: Hurrah Casino Schweiz. Deutsch. Kein HTML.",$ANTHROPIC_KEY,120);$faq_de[$q]=trim($a);echo "✅ FAQ DE\n";}

$schemaFaq=['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>[]];
foreach($faq_fr as $q=>$a) $schemaFaq['mainEntity'][]=['@type'=>'Question','name'=>$q,'acceptedAnswer'=>['@type'=>'Answer','text'=>$a]];
$schemaOrg=['@context'=>'https://schema.org','@type'=>'WebSite','name'=>'Hurrah Casino','url'=>'https://hurrahcasino.ch/','description'=>'Meilleur guide casino en ligne Suisse. Bester Online Casino Ratgeber Schweiz.'];

$faqFrHtml='';foreach($faq_fr as $q=>$a){$faqFrHtml.='<div class="faq-item"><button class="faq-btn" onclick="tFaq(this)" aria-expanded="false"><span>'.htmlspecialchars($q).'</span><svg class="faq-ico" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button><div class="faq-ans" hidden><p>'.htmlspecialchars($a).'</p></div></div>';}
$faqDeHtml='';foreach($faq_de as $q=>$a){$faqDeHtml.='<div class="faq-item"><button class="faq-btn" onclick="tFaq(this)" aria-expanded="false"><span>'.htmlspecialchars($q).'</span><svg class="faq-ico" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button><div class="faq-ans" hidden><p>'.htmlspecialchars($a).'</p></div></div>';}

echo "\n📄 Building HTML...\n";
$css='
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
:root{
  --red:#c0392b;--red2:#e74c3c;--gold:#d4a017;--gold2:#f1c40f;
  --dark:#080808;--dark2:#111;--dark3:#1a1a1a;
  --white:#fff;--off:#f8f8f8;--ink:#111;--ink2:#333;--ink3:#555;
  --gray:#888;--gray2:#bbb;--border:#e0e0e0;
  --green:#27ae60;--shadow:0 2px 12px rgba(0,0,0,.08);--shadow-md:0 4px 20px rgba(0,0,0,.12);
  --r:12px;--r-sm:8px;
}
html{font-size:16px;-webkit-text-size-adjust:100%;scroll-behavior:smooth}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--off);color:var(--ink);line-height:1.7;overflow-x:hidden;padding-bottom:70px}
@media(min-width:1024px){body{padding-bottom:0}}
img{max-width:100%;height:auto;display:block}
a{color:inherit;text-decoration:none}
button{font-family:inherit;cursor:pointer;border:none;background:none}
.wrap{width:100%;max-width:1160px;margin:0 auto;padding:0 16px}
@media(min-width:640px){.wrap{padding:0 24px}}
@media(min-width:1024px){.wrap{padding:0 32px}}
.lang-bar{background:var(--dark);border-bottom:1px solid rgba(255,255,255,.06);padding:8px 0}
.lang-bar-in{display:flex;align-items:center;justify-content:space-between;gap:12px}
.lang-btns{display:flex;gap:6px}
.lang-btn{display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.1);transition:.15s;cursor:pointer}
.lang-btn:hover{color:#fff;border-color:rgba(255,255,255,.3)}
.lang-btn.active{background:var(--red);color:#fff;border-color:var(--red)}
.lang-info{font-size:12px;color:rgba(255,255,255,.3)}
.hdr{background:var(--dark);position:sticky;top:0;z-index:100;border-bottom:2px solid var(--red)}
.hdr-in{display:flex;align-items:center;justify-content:space-between;gap:12px;height:58px}
.logo{display:flex;align-items:center;gap:10px}
.logo-txt{font-size:22px;font-weight:900;color:#fff;letter-spacing:-.5px}
.logo-txt span{color:var(--red)}
.logo-badge{font-size:10px;background:var(--gold);color:var(--dark);padding:2px 8px;border-radius:20px;font-weight:700;letter-spacing:.5px;text-transform:uppercase}
.hdr-nav{display:none;gap:2px}
@media(min-width:768px){.hdr-nav{display:flex}}
.hdr-nav a{color:rgba(255,255,255,.6);font-size:13px;font-weight:500;padding:6px 12px;border-radius:6px;transition:.15s}
.hdr-nav a:hover{color:#fff;background:rgba(255,255,255,.07)}
.hdr-cta{background:var(--red);color:#fff;padding:9px 16px;border-radius:7px;font-weight:700;font-size:13px;white-space:nowrap;transition:.15s;flex-shrink:0}
.hdr-cta:hover{background:var(--red2)}
.hero{background:linear-gradient(160deg,var(--dark) 0%,#1a0a0a 50%,#0d0505 100%);padding:40px 0 0;overflow:hidden;position:relative}
.hero::before{content:"";position:absolute;inset:0;background:radial-gradient(ellipse at 20% 50%,rgba(192,57,43,.08) 0,transparent 60%);pointer-events:none}
.hero-inner{position:relative;display:grid;grid-template-columns:1fr;gap:32px;padding-bottom:40px}
@media(min-width:900px){.hero-inner{grid-template-columns:1fr 1fr;align-items:center}}
.hero-eyebrow{display:inline-flex;align-items:center;gap:7px;background:rgba(192,57,43,.12);border:1px solid rgba(192,57,43,.3);color:var(--red2);font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:5px 14px;border-radius:20px;margin-bottom:20px}
.hero h1{font-size:clamp(42px,8vw,80px);font-weight:900;color:#fff;line-height:1;letter-spacing:-2px;margin-bottom:16px}
.hero h1 span{color:var(--red)}
.hero-sub{font-size:clamp(15px,2.5vw,20px);color:rgba(255,255,255,.6);margin-bottom:10px;font-weight:400;line-height:1.4}
.hero-sub strong{color:var(--gold)}
.hero-desc{font-size:15px;color:rgba(255,255,255,.5);line-height:1.7;margin-bottom:28px;max-width:480px}
.hero-lang-cta{display:flex;gap:10px;flex-wrap:wrap}
.lang-cta-btn{display:flex;align-items:center;gap:8px;padding:12px 20px;border-radius:9px;border:2px solid;font-weight:700;font-size:14px;transition:.2s;cursor:pointer;text-decoration:none}
.lang-cta-btn.fr{border-color:var(--red);color:var(--red);background:rgba(192,57,43,.06)}
.lang-cta-btn.fr:hover{background:var(--red);color:#fff}
.lang-cta-btn.de{border-color:var(--gold);color:var(--gold);background:rgba(212,160,23,.06)}
.lang-cta-btn.de:hover{background:var(--gold);color:var(--dark)}
.hero-scores{display:flex;gap:20px;flex-wrap:wrap;margin-top:20px}
.hero-score{text-align:center}
.hero-score-n{font-size:32px;font-weight:900;color:var(--gold);line-height:1}
.hero-score-l{font-size:11px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;margin-top:3px}
.hero-score-div{width:1px;background:rgba(255,255,255,.1);align-self:stretch}
.hero-stats{background:rgba(255,255,255,.03);border-top:1px solid rgba(255,255,255,.06);border-bottom:1px solid rgba(255,255,255,.06)}
.stats-row{display:grid;grid-template-columns:repeat(2,1fr)}
@media(min-width:480px){.stats-row{grid-template-columns:repeat(4,1fr)}}
.stat{padding:14px;text-align:center;border-right:1px solid rgba(255,255,255,.06)}
.stat:nth-child(2){border-right:none}
@media(min-width:480px){.stat:nth-child(2){border-right:1px solid rgba(255,255,255,.06)}}
.stat:last-child{border-right:none}
.stat-n{font-size:22px;font-weight:900;color:var(--red2);display:block;line-height:1}
.stat-l{font-size:10px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.5px;margin-top:3px;display:block}
[data-lang="de"]{display:none}
.lang-de [data-lang="fr"]{display:none}
.lang-de [data-lang="de"]{display:block}
.page-wrap{display:grid;grid-template-columns:1fr;gap:24px;padding:28px 0}
@media(min-width:1024px){.page-wrap{grid-template-columns:1fr 290px;gap:28px;align-items:start}}
.art h2{font-size:clamp(20px,3.5vw,28px);font-weight:800;color:var(--ink);margin:40px 0 13px;padding-top:28px;border-top:2px solid var(--border);line-height:1.25;letter-spacing:-.3px}
.art h2:first-child{margin-top:0;padding-top:0;border-top:none}
.art h2 .ac{color:var(--red)}
.art h3{font-size:18px;font-weight:700;color:var(--ink2);margin:22px 0 10px}
.art p{font-size:15px;color:var(--ink3);line-height:1.85;margin-bottom:15px}
.art strong{color:var(--ink);font-weight:700}
.art ul,.art ol{margin:0 0 16px;padding-left:22px}
.art li{font-size:15px;color:var(--ink3);margin-bottom:8px;line-height:1.7}
.art a{color:var(--red);font-weight:600}
.c-stack{display:flex;flex-direction:column;gap:14px;margin:18px 0}
.c-item{background:#fff;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;box-shadow:var(--shadow);transition:box-shadow .2s,transform .15s;position:relative}
.c-item:hover{box-shadow:var(--shadow-md);transform:translateY(-1px)}
.c-bar{height:4px;background:linear-gradient(90deg,var(--red),var(--red2))}
.c-bar.gold{background:linear-gradient(90deg,var(--gold),var(--gold2))}
.c-badge{position:absolute;top:0;right:14px;background:var(--gold);color:var(--dark);font-size:10px;font-weight:700;padding:3px 10px;border-radius:0 0 7px 7px;letter-spacing:.5px;text-transform:uppercase}
.c-body{padding:14px}
@media(min-width:560px){.c-body{display:grid;grid-template-columns:1fr auto;gap:14px;align-items:center}}
.c-rank{display:inline-flex;width:26px;height:26px;background:var(--dark);color:#fff;border-radius:50%;font-size:13px;font-weight:700;align-items:center;justify-content:center;margin-bottom:8px}
.c-name{font-size:17px;font-weight:800;color:var(--ink);margin-bottom:3px}
.c-bonus{font-size:13px;font-weight:600;color:var(--red);margin-bottom:9px}
.c-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:8px}
.ctag{font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;border:1px solid;background:rgba(192,57,43,.05);color:var(--red);border-color:rgba(192,57,43,.2)}
.ctag-g{background:rgba(39,174,96,.05);color:var(--green);border-color:rgba(39,174,96,.2)}
.c-desc{font-size:12px;color:var(--gray);line-height:1.5}
.c-side{display:flex;flex-direction:row;align-items:center;justify-content:space-between;gap:10px;padding-top:12px;border-top:1px solid var(--border);margin-top:12px}
@media(min-width:560px){.c-side{flex-direction:column;padding-top:0;border-top:none;margin-top:0;border-left:1px solid var(--border);padding-left:14px;min-width:110px}}
.c-score{font-size:30px;font-weight:800;color:var(--ink);line-height:1;text-align:center}
.c-stars{color:var(--gold);font-size:13px;text-align:center}
.c-btn{display:block;background:var(--red);color:#fff;padding:10px 16px;border-radius:var(--r-sm);font-weight:700;font-size:13px;text-align:center;transition:.15s;white-space:nowrap}
.c-btn:hover{background:var(--red2)}
.tbl-wrap{overflow-x:auto;margin:18px 0;border-radius:var(--r-sm);border:1px solid var(--border);box-shadow:var(--shadow)}
.tbl{width:100%;border-collapse:collapse;font-size:14px;background:#fff;min-width:500px}
.tbl thead tr{background:var(--dark)}
.tbl th{padding:11px 13px;color:rgba(255,255,255,.85);font-size:11px;font-weight:700;text-align:left;letter-spacing:.5px;text-transform:uppercase}
.tbl td{padding:10px 13px;border-bottom:1px solid var(--border);color:var(--ink3)}
.tbl tr:last-child td{border-bottom:none}
.tbl tr:nth-child(even) td{background:var(--off)}
.tbl tr.hl td{background:rgba(212,160,23,.07);font-weight:600;color:var(--ink)}
.chk{color:var(--green);font-weight:700;font-size:15px}
.crs{color:var(--red);font-weight:700}
.ib{background:rgba(192,57,43,.04);border:1px solid rgba(192,57,43,.15);border-left:4px solid var(--red);border-radius:0 var(--r-sm) var(--r-sm) 0;padding:16px 18px;margin:18px 0}
.ib-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--red);margin-bottom:5px}
.ib p{margin:0;font-size:14px;color:var(--ink2)}
.faq-list{display:flex;flex-direction:column;gap:7px;margin:18px 0}
.faq-item{background:#fff;border:1px solid var(--border);border-radius:var(--r-sm);overflow:hidden}
.faq-btn{width:100%;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;gap:10px;text-align:left;transition:.15s}
.faq-btn:hover{background:rgba(192,57,43,.03)}
.faq-btn[aria-expanded="true"]{background:rgba(192,57,43,.05)}
.faq-btn span{font-size:14px;font-weight:600;color:var(--ink);line-height:1.4}
.faq-ico{color:var(--red);flex-shrink:0;transition:transform .2s}
.faq-btn[aria-expanded="true"] .faq-ico{transform:rotate(180deg)}
.faq-ans{padding:0 16px;font-size:14px;color:var(--ink3);line-height:1.75}
.faq-ans p{padding-bottom:14px;margin:0}
.faq-ans[hidden]{display:none}
.cta-blk{background:linear-gradient(135deg,var(--dark),#1a0505);border-radius:var(--r);padding:28px 24px;margin:24px 0;text-align:center;border:1px solid rgba(192,57,43,.2)}
.cta-blk h3{font-size:20px;font-weight:800;color:#fff;margin-bottom:8px}
.cta-blk p{font-size:13px;color:rgba(255,255,255,.5);margin-bottom:20px}
.cta-disc{font-size:11px;color:rgba(255,255,255,.25);margin-top:10px}
.btn-red{display:inline-flex;align-items:center;gap:7px;background:var(--red);color:#fff;padding:14px 24px;border-radius:9px;font-weight:700;font-size:15px;transition:.2s;white-space:nowrap}
.btn-red:hover{background:var(--red2);transform:translateY(-1px)}
.sb{display:flex;flex-direction:column;gap:14px}
@media(min-width:1024px){.sb{position:sticky;top:74px}}
.w{background:#fff;border:1px solid var(--border);border-radius:var(--r-sm);overflow:hidden;box-shadow:var(--shadow)}
.w-h{padding:10px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px}
.w-h.dk{background:var(--dark);color:#fff}
.w-h.rd{background:var(--red);color:#fff}
.w-h.gd{background:var(--gold);color:var(--dark)}
.w-h.gy{background:var(--off);color:var(--gray);border-bottom:1px solid var(--border)}
.w-b{padding:14px}
.w-cn{font-size:17px;font-weight:700;color:var(--ink);text-align:center;margin-bottom:3px}
.w-cb{font-size:13px;font-weight:600;color:var(--red);text-align:center;margin-bottom:12px}
.w-btn{display:block;background:var(--red);color:#fff;padding:11px;border-radius:var(--r-sm);text-align:center;font-weight:700;font-size:14px;transition:.15s;margin-bottom:7px}
.w-btn:hover{background:var(--red2)}
.w-btn.gold{background:var(--gold);color:var(--dark)}
.w-btn.gold:hover{background:var(--gold2)}
.w-disc{font-size:10px;color:var(--gray2);text-align:center}
.w-ul{list-style:none}
.w-ul li{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;gap:8px}
.w-ul li:last-child{border-bottom:none}
.w-ul .lb{color:var(--gray);flex-shrink:0}
.w-ul .vl{font-weight:600;color:var(--ink2);text-align:right}
.w-ul .ok{color:var(--green);font-weight:700}
.toc{list-style:none;counter-reset:toc}
.toc li{counter-increment:toc}
.toc a{display:flex;align-items:center;gap:9px;padding:8px 0;border-bottom:1px solid var(--border);color:var(--ink2);font-size:13px;transition:.15s;line-height:1.4}
.toc a::before{content:counter(toc);background:var(--off);border:1px solid var(--border);color:var(--red);font-size:11px;font-weight:700;width:20px;height:20px;border-radius:5px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.toc a:hover{color:var(--red)}
.toc li:last-child a{border-bottom:none}
.footer{background:var(--dark);color:rgba(255,255,255,.5);padding:36px 0 22px;margin-top:40px}
.f-grid{display:grid;grid-template-columns:1fr;gap:22px;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid rgba(255,255,255,.07)}
@media(min-width:640px){.f-grid{grid-template-columns:2fr 1fr 1fr}}
.f-logo{font-size:20px;font-weight:900;color:#fff;margin-bottom:7px}
.f-logo span{color:var(--red)}
.f-desc{font-size:13px;line-height:1.6;color:rgba(255,255,255,.35)}
.f-col h4{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.25);margin-bottom:10px}
.f-ul{list-style:none}
.f-ul li{margin-bottom:8px}
.f-ul a{color:rgba(255,255,255,.45);font-size:13px;transition:.15s}
.f-ul a:hover{color:#fff}
.f-bot{font-size:12px;color:rgba(255,255,255,.22);line-height:1.8}
.f-bot a{color:rgba(255,255,255,.28)}
.m-cta{display:flex;position:fixed;bottom:0;left:0;right:0;background:var(--dark);border-top:2px solid var(--red);padding:10px 14px;gap:10px;align-items:center;z-index:99;box-shadow:0 -3px 16px rgba(0,0,0,.3)}
@media(min-width:1024px){.m-cta{display:none}}
.m-cta-i{flex:1;min-width:0}
.m-cta-i strong{display:block;font-size:13px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.m-cta-i span{display:block;font-size:11px;color:rgba(255,255,255,.45);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.m-cta-btn{background:var(--red);color:#fff;padding:10px 16px;border-radius:7px;font-weight:700;font-size:13px;white-space:nowrap;flex-shrink:0}
.m-cta-btn:hover{background:var(--red2)}
';
$html='<!DOCTYPE html>
<html lang="fr" id="html-root">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#080808">
<title>Hurrah Casino — Meilleur Casino en Ligne Suisse | HurrahCasino.ch</title>
<meta name="description" content="Hurrah Casino — guide casino en ligne de référence pour la Suisse. Meilleurs casinos, bonus CHF, free spins. Bestes Online Casino Schweiz.">
<meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1">
<meta property="og:type" content="website">
<meta property="og:title" content="Hurrah Casino — Meilleur Casino en Ligne Suisse">
<meta property="og:locale" content="fr_CH">
<meta property="og:locale:alternate" content="de_CH">
<meta property="og:site_name" content="Hurrah Casino">
<link rel="canonical" href="https://hurrahcasino.ch/">
<link rel="alternate" hreflang="fr" href="https://hurrahcasino.ch/fr/">
<link rel="alternate" hreflang="de" href="https://hurrahcasino.ch/de/">
<link rel="alternate" hreflang="x-default" href="https://hurrahcasino.ch/">
<link rel="icon" type="image/png" href="/favicon.png">
<script type="application/ld+json">'.json_encode($schemaFaq,JSON_UNESCAPED_UNICODE).'</script>
<script type="application/ld+json">'.json_encode($schemaOrg,JSON_UNESCAPED_UNICODE).'</script>
<style>'.$css.'</style>
</head>
<body>
<div class="lang-bar"><div class="wrap lang-bar-in">
  <div class="lang-info" data-lang="fr">🇨🇭 Guide Casino Suisse</div>
  <div class="lang-info" data-lang="de">🇨🇭 Schweizer Casino Ratgeber</div>
  <div class="lang-btns">
    <button class="lang-btn active" onclick="setLang(\'fr\')" id="btn-fr">🇫🇷 Français</button>
    <button class="lang-btn" onclick="setLang(\'de\')" id="btn-de">🇩🇪 Deutsch</button>
  </div>
</div></div>
<header class="hdr"><div class="wrap hdr-in">
  <a href="/" class="logo">
    <div class="logo-txt">Hurrah<span>Casino</span></div>
    <div class="logo-badge">🇨🇭 Suisse</div>
  </a>
  <nav class="hdr-nav">
    <a href="#top5">Top 5</a>
    <a href="#bonus" data-lang="fr">Bonus</a>
    <a href="#bonus-de" data-lang="de">Bonus</a>
    <a href="#faq">FAQ</a>
    <a href="/fr/">🇫🇷 FR</a>
    <a href="/de/">🇩🇪 DE</a>
  </nav>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="hdr-cta" data-lang="fr">Jouer →</a>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="hdr-cta" data-lang="de">Spielen →</a>
</div></header>
<section class="hero"><div class="wrap">
  <div class="hero-inner">
    <div>
      <div class="hero-eyebrow" data-lang="fr">🏆 Guide Casino #1 Suisse</div>
      <div class="hero-eyebrow" data-lang="de">🏆 Casino Ratgeber #1 Schweiz</div>
      <h1>Hurrah<span>Casino</span></h1>
      <div class="hero-sub" data-lang="fr"><strong>Meilleur Casino en Ligne Suisse</strong> — Guide FR & DE</div>
      <div class="hero-sub" data-lang="de"><strong>Bestes Online Casino Schweiz</strong> — FR & DE Guide</div>
      <p class="hero-desc" data-lang="fr">Guide indépendant des meilleurs casinos en ligne pour joueurs suisses. Bonus en CHF, casinos licenciés CFMJ et MGA, free spins exclusifs.</p>
      <p class="hero-desc" data-lang="de">Unabhängiger Ratgeber für die besten Online Casinos für Schweizer Spieler. CHF Boni, CFMJ und MGA lizenzierte Casinos, exklusive Free Spins.</p>
      <div class="hero-lang-cta">
        <a href="/fr/" class="lang-cta-btn fr">🇫🇷 Version Française →</a>
        <a href="/de/" class="lang-cta-btn de">🇩🇪 Deutsche Version →</a>
      </div>
      <div class="hero-scores">
        <div class="hero-score"><div class="hero-score-n">200+</div><div class="hero-score-l" data-lang="fr">Casinos testés</div><div class="hero-score-l" data-lang="de">Casinos getestet</div></div>
        <div class="hero-score-div"></div>
        <div class="hero-score"><div class="hero-score-n">3 ans</div><div class="hero-score-l" data-lang="fr">D\'expérience</div><div class="hero-score-l" data-lang="de">Erfahrung</div></div>
        <div class="hero-score-div"></div>
        <div class="hero-score"><div class="hero-score-n">8</div><div class="hero-score-l" data-lang="fr">Experts</div><div class="hero-score-l" data-lang="de">Experten</div></div>
      </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:12px">
      <div class="w" style="border:2px solid rgba(192,57,43,.3)">
        <div class="w-h gd" data-lang="fr">🏆 #1 Casino Recommandé</div>
        <div class="w-h gd" data-lang="de">🏆 #1 Empfohlenes Casino</div>
        <div class="w-b">
          <div class="w-cn">SwissGold Casino</div>
          <div class="w-cb">200 CHF + 100 Free Spins</div>
          <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="w-btn" data-lang="fr">Jouer Maintenant →</a>
          <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="w-btn" data-lang="de">Jetzt Spielen →</a>
          <div class="w-disc" data-lang="fr">⚠️ 18+ · Sponsorisé</div>
          <div class="w-disc" data-lang="de">⚠️ 18+ · Gesponsert</div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="hero-stats"><div class="wrap"><div class="stats-row">
  <div class="stat"><span class="stat-n">200+</span><span class="stat-l" data-lang="fr">Casinos testés</span><span class="stat-l" data-lang="de">Casinos getestet</span></div>
  <div class="stat"><span class="stat-n">CHF</span><span class="stat-l" data-lang="fr">Bonus disponibles</span><span class="stat-l" data-lang="de">Bonus verfügbar</span></div>
  <div class="stat"><span class="stat-n">24/7</span><span class="stat-l">Support FR/DE</span></div>
  <div class="stat"><span class="stat-n">100%</span><span class="stat-l" data-lang="fr">Indépendant</span><span class="stat-l" data-lang="de">Unabhängig</span></div>
</div></div></div>
</section>
<div class="wrap"><div class="page-wrap">
<main class="art">
<div data-lang="fr">
<p>'.nl2br(htmlspecialchars($fr_intro)).'</p>
<div class="ib"><div class="ib-lbl">🏆 Hurrah Casino en bref</div><p>Guide indépendant suisse depuis 2021. <strong>200+ casinos testés</strong>, bonus en CHF, licences CFMJ et MGA vérifiées.</p></div>
<h2 id="top5">Hurrah Casino — <span class="ac">Top 5</span> Meilleurs Casinos Suisses</h2>
<p>'.nl2br(htmlspecialchars($fr_top)).'</p>
<div class="c-stack">
  <div class="c-item"><div class="c-bar gold"></div><div class="c-badge">⭐ #1</div>
    <div class="c-body"><div>
      <div class="c-rank">1</div><div class="c-name">SwissGold Casino</div>
      <div class="c-bonus">200 CHF + 100 Free Spins</div>
      <div class="c-tags"><span class="ctag">MGA</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">TWINT ✓</span><span class="ctag">Support FR</span></div>
      <div class="c-desc">Meilleur casino suisse selon nos tests. Bonus généreux en CHF, support francophone 24/7.</div>
    </div>
    <div class="c-side"><div><div class="c-score">9.4</div><div class="c-stars">★★★★★</div></div>
      <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Jouer →</a>
    </div></div>
  </div>
  <div class="c-item"><div class="c-bar"></div>
    <div class="c-body"><div>
      <div class="c-rank">2</div><div class="c-name">AlpinePlay Casino</div>
      <div class="c-bonus">150 CHF + 50 Free Spins</div>
      <div class="c-tags"><span class="ctag">CFMJ</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">PostFinance ✓</span></div>
      <div class="c-desc">Seul casino avec licence CFMJ. Idéal pour joueurs suisses romands.</div>
    </div>
    <div class="c-side"><div><div class="c-score">9.1</div><div class="c-stars">★★★★★</div></div>
      <a href="'.$AFF2.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Jouer →</a>
    </div></div>
  </div>
  <div class="c-item"><div class="c-bar"></div>
    <div class="c-body"><div>
      <div class="c-rank">3</div><div class="c-name">LémanCasino</div>
      <div class="c-bonus">300 CHF — Meilleur Live Casino</div>
      <div class="c-tags"><span class="ctag">MGA</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">Live ✓</span></div>
      <div class="c-desc">Meilleure expérience live casino en Suisse. Evolution Gaming disponible.</div>
    </div>
    <div class="c-side"><div><div class="c-score">8.9</div><div class="c-stars">★★★★½</div></div>
      <a href="'.$AFF3.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Jouer →</a>
    </div></div>
  </div>
</div>
<div class="tbl-wrap"><table class="tbl">
  <thead><tr><th>Casino</th><th>Bonus</th><th>Licence</th><th>CHF</th><th>TWINT</th><th>Support FR</th></tr></thead>
  <tbody>
    <tr class="hl"><td>🏆 SwissGold</td><td>200 CHF + 100 FS</td><td>MGA</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>AlpinePlay</td><td>150 CHF + 50 FS</td><td>CFMJ</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>LémanCasino</td><td>300 CHF</td><td>MGA</td><td class="chk">✓</td><td class="crs">✗</td><td class="chk">✓</td></tr>
    <tr><td>HelvétiaSlots</td><td>100 CHF sans dépôt</td><td>MGA</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>GenevaWin</td><td>250 CHF + Cashback</td><td>MGA</td><td class="chk">✓</td><td class="crs">✗</td><td class="chk">✓</td></tr>
  </tbody>
</table></div>
<h2>Qu\'est-ce que <span class="ac">Hurrah Casino</span>?</h2>
<p>'.nl2br(htmlspecialchars($fr_about)).'</p>
<h2 id="bonus">Guide des <span class="ac">Bonus Casino</span> Suisses</h2>
<p>'.nl2br(htmlspecialchars($fr_bonus)).'</p>
<h2>Méthodes de <span class="ac">Paiement</span></h2>
<p>'.nl2br(htmlspecialchars($fr_pays)).'</p>
<div class="cta-blk">
  <h3>🎰 Jouer au Meilleur Casino Suisse</h3>
  <p>Sponsorisé · 18+ · Jouez de manière responsable</p>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="btn-red">Jouer chez SwissGold →</a>
  <div class="cta-disc">⚠️ Lien sponsorisé — 18+</div>
</div>
<h2 id="faq">FAQ — <span class="ac">Hurrah Casino</span></h2>
<div class="faq-list">'.$faqFrHtml.'</div>
<h2>Conclusion</h2>
<p>'.nl2br(htmlspecialchars($fr_concl)).'</p>
<div style="background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:16px 18px;margin:24px 0">
  <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray2);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border)">🔗 Versions complètes</div>
  <a href="/fr/" style="display:flex;align-items:center;gap:8px;padding:9px 0;border-bottom:1px solid var(--border);color:var(--ink);font-weight:600;font-size:14px">🇫🇷 Hurrah Casino — Version Française complète</a>
  <a href="/de/" style="display:flex;align-items:center;gap:8px;padding:9px 0;color:var(--ink);font-weight:600;font-size:14px">🇩🇪 Hurrah Casino — Vollständige Deutsche Version</a>
</div>
</div>
<div data-lang="de">
<p>'.nl2br(htmlspecialchars($de_intro)).'</p>
<div class="ib"><div class="ib-lbl">🏆 Hurrah Casino im Überblick</div><p>Unabhängiger Schweizer Ratgeber seit 2021. <strong>200+ getestete Casinos</strong>, CHF Boni, geprüfte CFMJ und MGA Lizenzen.</p></div>
<h2 id="top5-de">Hurrah Casino — <span class="ac">Top 5</span> Beste Schweizer Online Casinos</h2>
<p>'.nl2br(htmlspecialchars($de_top)).'</p>
<div class="c-stack">
  <div class="c-item"><div class="c-bar gold"></div><div class="c-badge">⭐ #1</div>
    <div class="c-body"><div>
      <div class="c-rank">1</div><div class="c-name">SwissGold Casino</div>
      <div class="c-bonus">200 CHF Bonus + 100 Free Spins</div>
      <div class="c-tags"><span class="ctag">MGA</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">TWINT ✓</span><span class="ctag">DE Support</span></div>
      <div class="c-desc">Das beste Schweizer Casino laut unseren Tests. Großzügige CHF Boni, deutschsprachiger Support 24/7.</div>
    </div>
    <div class="c-side"><div><div class="c-score">9.4</div><div class="c-stars">★★★★★</div></div>
      <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Spielen →</a>
    </div></div>
  </div>
  <div class="c-item"><div class="c-bar"></div>
    <div class="c-body"><div>
      <div class="c-rank">2</div><div class="c-name">AlpinePlay Casino</div>
      <div class="c-bonus">150 CHF + 50 Free Spins</div>
      <div class="c-tags"><span class="ctag">CFMJ</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">PostFinance ✓</span></div>
      <div class="c-desc">Einziges Casino mit CFMJ-Lizenz. Ideal für Schweizer Spieler.</div>
    </div>
    <div class="c-side"><div><div class="c-score">9.1</div><div class="c-stars">★★★★★</div></div>
      <a href="'.$AFF2.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Spielen →</a>
    </div></div>
  </div>
  <div class="c-item"><div class="c-bar"></div>
    <div class="c-body"><div>
      <div class="c-rank">3</div><div class="c-name">ZürichCasino</div>
      <div class="c-bonus">300 CHF — Bestes Live Casino</div>
      <div class="c-tags"><span class="ctag">MGA</span><span class="ctag ctag-g">CHF ✓</span><span class="ctag">Live ✓</span></div>
      <div class="c-desc">Bestes Live Casino Erlebnis in der Schweiz. Evolution Gaming verfügbar.</div>
    </div>
    <div class="c-side"><div><div class="c-score">8.9</div><div class="c-stars">★★★★½</div></div>
      <a href="'.$AFF3.'" target="_blank" rel="nofollow noopener sponsored" class="c-btn">Spielen →</a>
    </div></div>
  </div>
</div>
<div class="tbl-wrap"><table class="tbl">
  <thead><tr><th>Casino</th><th>Bonus</th><th>Lizenz</th><th>CHF</th><th>TWINT</th><th>DE Support</th></tr></thead>
  <tbody>
    <tr class="hl"><td>🏆 SwissGold</td><td>200 CHF + 100 FS</td><td>MGA</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>AlpinePlay</td><td>150 CHF + 50 FS</td><td>CFMJ</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>ZürichCasino</td><td>300 CHF</td><td>MGA</td><td class="chk">✓</td><td class="crs">✗</td><td class="chk">✓</td></tr>
    <tr><td>HelvétiaSlots</td><td>100 CHF ohne Einzahlung</td><td>MGA</td><td class="chk">✓</td><td class="chk">✓</td><td class="chk">✓</td></tr>
    <tr><td>BernerWin</td><td>250 CHF + Cashback</td><td>MGA</td><td class="chk">✓</td><td class="crs">✗</td><td class="chk">✓</td></tr>
  </tbody>
</table></div>
<h2>Was ist <span class="ac">Hurrah Casino</span>?</h2>
<p>'.nl2br(htmlspecialchars($de_about)).'</p>
<h2 id="bonus-de">Leitfaden für <span class="ac">Casino Boni</span></h2>
<p>'.nl2br(htmlspecialchars($de_bonus)).'</p>
<h2>Zahlungsmethoden</h2>
<p>'.nl2br(htmlspecialchars($de_zahlung)).'</p>
<div class="cta-blk">
  <h3>🎰 Im besten Schweizer Casino spielen</h3>
  <p>Gesponsert · 18+ · Verantwortungsvoll spielen</p>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="btn-red">Bei SwissGold spielen →</a>
  <div class="cta-disc">⚠️ Gesponserte Link — 18+</div>
</div>
<h2 id="faq-de">FAQ — <span class="ac">Hurrah Casino</span></h2>
<div class="faq-list">'.$faqDeHtml.'</div>
<h2>Fazit</h2>
<p>'.nl2br(htmlspecialchars($de_concl)).'</p>
<div style="background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:16px 18px;margin:24px 0">
  <div style="font-size:11px;font-weight:700;text-transform:uppercase;color:var(--gray2);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border)">🔗 Vollständige Versionen</div>
  <a href="/fr/" style="display:flex;align-items:center;gap:8px;padding:9px 0;border-bottom:1px solid var(--border);color:var(--ink);font-weight:600;font-size:14px">🇫🇷 Hurrah Casino — Französische Version</a>
  <a href="/de/" style="display:flex;align-items:center;gap:8px;padding:9px 0;color:var(--ink);font-weight:600;font-size:14px">🇩🇪 Hurrah Casino — Deutsche Version</a>
</div>
</div>
</main>
<aside class="sb">
  <div class="w"><div class="w-h gd" data-lang="fr">🏆 #1 Recommandé</div><div class="w-h gd" data-lang="de">🏆 #1 Empfohlen</div>
  <div class="w-b">
    <div style="text-align:center;font-size:32px;margin-bottom:8px">🎰</div>
    <div class="w-cn">SwissGold Casino</div>
    <div class="w-cb">200 CHF + 100 Free Spins</div>
    <ul class="w-ul" style="margin-bottom:12px">
      <li><span class="lb">Bonus</span><span class="vl">200 CHF</span></li>
      <li><span class="lb">Free Spins</span><span class="vl">100 FS</span></li>
      <li><span class="lb">Licence</span><span class="ok">MGA ✓</span></li>
      <li><span class="lb">CHF</span><span class="ok">✓ Oui/Ja</span></li>
      <li><span class="lb">TWINT</span><span class="ok">✓ Oui/Ja</span></li>
    </ul>
    <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="w-btn" data-lang="fr">Jouer Maintenant →</a>
    <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="w-btn" data-lang="de">Jetzt Spielen →</a>
    <div class="w-disc" data-lang="fr">⚠️ 18+ · Sponsorisé</div>
    <div class="w-disc" data-lang="de">⚠️ 18+ · Gesponsert</div>
  </div></div>
  <div class="w"><div class="w-h dk" data-lang="fr">📋 Sommaire</div><div class="w-h dk" data-lang="de">📋 Inhaltsverzeichnis</div>
  <div class="w-b">
    <ol class="toc" data-lang="fr">
      <li><a href="#top5">Top 5 Casinos</a></li>
      <li><a href="#bonus">Guide Bonus</a></li>
      <li><a href="#faq">FAQ</a></li>
    </ol>
    <ol class="toc" data-lang="de">
      <li><a href="#top5-de">Top 5 Casinos</a></li>
      <li><a href="#bonus-de">Bonus Leitfaden</a></li>
      <li><a href="#faq-de">FAQ</a></li>
    </ol>
  </div></div>
  <div class="w"><div class="w-h gy">🇨🇭 Hurrah Casino</div>
  <div class="w-b">
    <a href="/fr/" class="w-btn" style="margin-bottom:8px">🇫🇷 Version Française →</a>
    <a href="/de/" class="w-btn gold">🇩🇪 Deutsche Version →</a>
  </div></div>
  <div class="w"><div class="w-h rd">⚠️ Jeu Responsable</div>
  <div class="w-b">
    <ul class="w-ul">
      <li><span class="lb">🇨🇭 Aide/Hilfe</span><a href="https://www.addiction-suisse.ch" target="_blank" rel="noopener" style="color:var(--red);font-size:13px;font-weight:600">addiction-suisse.ch</a></li>
    </ul>
  </div></div>
</aside>
</div></div>
<footer class="footer"><div class="wrap">
  <div class="f-grid">
    <div>
      <div class="f-logo">Hurrah<span>Casino</span></div>
      <p class="f-desc" data-lang="fr">Guide indépendant des meilleurs casinos en ligne pour joueurs suisses.</p>
      <p class="f-desc" data-lang="de">Unabhängiger Ratgeber für die besten Online Casinos für Schweizer Spieler.</p>
    </div>
    <div><h4>Links</h4><ul class="f-ul">
      <li><a href="/">Hurrah Casino</a></li>
      <li><a href="/fr/">🇫🇷 Version FR</a></li>
      <li><a href="/de/">🇩🇪 Version DE</a></li>
    </ul></div>
    <div><h4>Info</h4><ul class="f-ul">
      <li><a href="/" data-lang="fr">À propos</a><a href="/" data-lang="de">Über uns</a></li>
      <li><a href="/">Contact</a></li>
      <li><a href="/" data-lang="fr">Confidentialité</a><a href="/" data-lang="de">Datenschutz</a></li>
    </ul></div>
  </div>
  <div class="f-bot">
    <p data-lang="fr">⚠️ <strong>18+ | Jouez de manière responsable.</strong> HurrahCasino.ch contient des liens sponsorisés. | <a href="/">Confidentialité</a></p>
    <p data-lang="de">⚠️ <strong>18+ | Verantwortungsvoll spielen.</strong> HurrahCasino.ch enthält gesponserte Links. | <a href="/">Datenschutz</a></p>
    <p style="margin-top:5px">© '.date('Y').' HurrahCasino.ch — Schweiz / Suisse</p>
  </div>
</div></footer>
<div class="m-cta">
  <div class="m-cta-i">
    <strong>🎰 SwissGold Casino</strong>
    <span>200 CHF + 100 FS · MGA</span>
  </div>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="m-cta-btn" data-lang="fr">Jouer →</a>
  <a href="'.$AFF1.'" target="_blank" rel="nofollow noopener sponsored" class="m-cta-btn" data-lang="de">Spielen →</a>
</div>
<script>
function setLang(lang){
  var root=document.getElementById("html-root");
  root.setAttribute("lang",lang);
  if(lang==="de"){root.classList.add("lang-de")}else{root.classList.remove("lang-de")}
  document.getElementById("btn-fr").classList.toggle("active",lang==="fr");
  document.getElementById("btn-de").classList.toggle("active",lang==="de");
  try{localStorage.setItem("hurrah-lang",lang);}catch(e){}
}
function tFaq(btn){
  var isOpen=btn.getAttribute("aria-expanded")==="true";
  document.querySelectorAll(".faq-btn[aria-expanded=\"true\"]").forEach(function(b){
    b.setAttribute("aria-expanded","false");b.nextElementSibling.hidden=true;
  });
  if(!isOpen){btn.setAttribute("aria-expanded","true");btn.nextElementSibling.hidden=false;}
}
document.querySelectorAll("a[href^=\"#\"]").forEach(function(a){
  a.addEventListener("click",function(e){
    var t=document.querySelector(a.getAttribute("href"));
    if(t){e.preventDefault();var top=t.getBoundingClientRect().top+window.pageYOffset-70;window.scrollTo({top:top,behavior:"smooth"});}
  });
});
(function(){
  try{
    var saved=localStorage.getItem("hurrah-lang");
    var lang=saved||(navigator.language||"fr").toLowerCase().startsWith("de")?"de":"fr";
    setLang(lang);
  }catch(e){setLang("fr");}
})();
</script>
</body>
</html>';

file_put_contents($BASE.'/index.html',$html);
echo "✅ Page: ".round(strlen($html)/1024)."KB\n";
echo "\n=== DONE ===\n";
echo "✅ hurrahcasino.ch/ — Bilingual FR/DE\n";
echo "✅ H1: Hurrah Casino\n";
echo "✅ JS lang switcher FR/DE\n";
echo "✅ Tables + Casino cards FR + DE\n";
echo "✅ FAQ FR + DE\n";
echo "⚠️  rm gen_hurrah_main.php\n";
