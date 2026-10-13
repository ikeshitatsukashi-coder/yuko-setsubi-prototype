<?php
/**
 * 有限会社友好設備 サイト お問い合わせ／エントリーフォーム 送信スクリプト
 * TOP(エントリー) と /contact/ の両フォームから POST される。
 */

/* ===== 設定 ===== */
$TO        = 'mitsunaritakeda0525@yahoo.co.jp';         // 受信先（友好設備様）
$FROM      = 'no-reply@yukoh-setsubi.jp';               // 送信元（独自ドメイン＝到達率対策）
$FROM_NAME = '友好設備サイト お問い合わせ';
$TEL       = '048-287-0666';

header('X-Content-Type-Options: nosniff');

/* POST以外は拒否 */
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

/* 迷惑メールBot対策（ハニーポット：人間には見えない項目。埋まっていたら破棄） */
if (!empty($_POST['company_url'] ?? '')) {
    echo json_encode(['ok' => true]); // Botには成功を装って黙って捨てる
    exit;
}

/* 値取得＆整形 */
function v($k){ return trim((string)($_POST[$k] ?? '')); }
$type    = v('type');
$name    = v('name');
$company = v('company');
$email   = v('email');
$contact = v('contact');   // TOPフォーム：メール or 電話
$tel     = v('tel');
$message = v('message');

/* 必須チェック */
if ($name === '' || $message === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'required']);
    exit;
}

/* ヘッダーインジェクション対策（改行除去）＋返信先の決定 */
$reply = $email !== '' ? $email : $contact;
$reply = preg_replace('/[\r\n]+/', '', $reply);
if (!filter_var($reply, FILTER_VALIDATE_EMAIL)) { $reply = ''; }

/* 種別ラベル */
$types = [
    'work'    => '工事のご依頼・お見積り',
    'recruit' => '採用エントリー',
    'partner' => '協力会社・パートナーのご相談',
    'press'   => '取材・プレスのお問い合わせ',
    'other'   => 'その他',
];
$typeLabel = $types[$type] ?? ($type !== '' ? $type : '（未選択）');

/* 本文組み立て */
$L = [];
$L[] = '有限会社友好設備のウェブサイトから、お問い合わせがありました。';
$L[] = '';
$L[] = '■ ご用件　：' . $typeLabel;
$L[] = '■ お名前　：' . $name;
if ($company !== '') $L[] = '■ 会社名　：' . $company;
if ($email   !== '') $L[] = '■ メール　：' . $email;
if ($contact !== '') $L[] = '■ 連絡先　：' . $contact;
if ($tel     !== '') $L[] = '■ 電話　　：' . $tel;
$L[] = '';
$L[] = '■ お問い合わせ内容：';
$L[] = $message;
$L[] = '';
$L[] = '----------------------------------------';
$L[] = '送信日時：' . date('Y-m-d H:i:s');
$L[] = '送信元　：https://yukoh-setsubi.jp/ のフォーム';
$body = implode("\n", $L);

/* 日本語メール送信 */
mb_language('Japanese');
mb_internal_encoding('UTF-8');

$subject = '【友好設備サイト】お問い合わせ（' . $typeLabel . '）';

$headers  = 'From: ' . mb_encode_mimeheader($FROM_NAME) . ' <' . $FROM . '>' . "\r\n";
if ($reply !== '') $headers .= 'Reply-To: ' . $reply . "\r\n";
$headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();

$ok = @mb_send_mail($TO, $subject, $body, $headers, '-f' . $FROM);

/* 応答 */
$isAjax = (($_POST['ajax'] ?? '') === '1') || (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest');
if ($isAjax) {
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(['ok' => (bool)$ok]);
} else {
    /* JS無効時のフォールバック：簡易サンクスページ */
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="ja"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>送信完了｜有限会社友好設備</title><style>body{font-family:-apple-system,"Hiragino Kaku Gothic ProN",sans-serif;background:#f6fafd;color:#0E2A47;margin:0}.box{max-width:620px;margin:14vh auto;padding:0 24px;text-align:center}.box h1{font-size:26px;margin:0 0 16px}.box p{line-height:1.9;color:#3f5568}.box a{display:inline-block;margin-top:28px;color:#2E8FBE;font-weight:700}</style></head><body><div class="box">';
    if ($ok) {
        echo '<h1>送信しました</h1><p>お問い合わせありがとうございます。<br>担当者より追ってご連絡いたします。</p>';
    } else {
        echo '<h1>送信に失敗しました</h1><p>申し訳ございません。お手数ですが、お電話（' . htmlspecialchars($TEL) . '）でお問い合わせください。</p>';
    }
    echo '<a href="https://yukoh-setsubi.jp/">トップページへ戻る</a></div></body></html>';
}
