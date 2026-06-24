<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1〜19個目: category_id => 1
            [
                'category_id' => 1,
                'product_name' => '【CONVERSE】ALL STAR Ⓡ HI 
',
                'description' => '次世代モデル！履き心地が進化した定番ハイカット
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【mobus】BASEL
',
                'description' => 'ドイツ発！上品なレザーが魅せる大人スニーカー',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【DC Shoes】DC SCORE
',
                'description' => 'ストリートに映えるタフでスタイリッシュな靴
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【New Balance】W996 
',
                'description' => '洗練されたシルエットと抜群のクッション性',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【SOARHOPE】ホワイトスニーカー',
                'description' => 'どんなコーデにも馴染む、清潔感抜群の白スニーカー',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【adidas】SAMBA OG',
                'description' => 'レトロな魅力が光る、アディダスの大人気名作',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【WIMBLEDON】テニスシューズ
',
                'description' => '日常使いにも最適な、軽快でスポーティな白靴',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【adidas】グランドコートベース 2.0Ｍ
',
                'description' => 'テニス風のクラシックな佇まいが魅力の1足',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【mobus】MELNIK
',
                'description' => '洗練されたフォルムで足元をスマートに演出
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【KAMIYA】Joey
',
                'description' => 'エッジの効いたデザインで魅せる個性派の1足',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【CONVERSE】ネクスター110 OX
',
                'description' => '軽量で合わせやすい、コンバースの万能ローカット',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【YOOCOYA】キッズスニーカー',
                'description' => '元気に動ける！子供の足に優しい軽量スニーカー',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【bope】レディーススニーカー
',
                'description' => '大人可愛さと歩きやすさを両立した万能シューズ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【FILA】Balena
',
                'description' => '厚底感が可愛い、フィラの上品アクティブシューズ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【Taobao】肉球靴
',
                'description' => '肉球モチーフがたまらない、遊び心満載の靴',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ZKGK】ダンススニーカー
',
                'description' => '優れたターンとクッション性でステップを軽快に',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ゴールデンベア】カジュアルスニーカー
',
                'description' => '大人の休日に寄り添う、履き心地抜群のデイリー靴',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ORiental TRaffic】キルティングデザインスニーカー
',
                'description' => '立体的なキルティングが上品な大人フェミニン靴',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【=Me】ME-3797
',
                'description' => '毎日履きたくなる、軽やかでトレンド感ある1足',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 20〜40個目（下から21個分）: category_id => 2
            [
                'category_id' => 2,
                'product_name' => '【YOKUNERU】ブラックTシャツ
',
                'description' => '着回し力抜群！シックに決まる定番黒Tシャツ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【FUZHIHUA】七分丈シャツ Blue
',
                'description' => '爽やかなブルーが目を惹く、大人の七分丈シャツ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【FUZHIHUA】七分丈シャツ Black
',
                'description' => 'クールに引き締まる、スタイリッシュな黒七分丈',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【VERAVANT】トレーナー
',
                'description' => 'リラックス感と今っぽさを兼ね備えたスウェット',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【TRAVAS TOKYO】パンダパーカー
',
                'description' => 'エッジの効いたパンダグラフィックが可愛い1着',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Sukinana】ブラックパーカー
',
                'description' => 'シンプルで男らしい、ヘビロテ確定の黒パーカ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Uptoyou】レイヤードトレーナー',
                'description' => '1枚で重ね着風のお洒落が完成する優秀スウェット',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【STARZORA】青パーカー
',
                'description' => '鮮やかなブルーがコーデの主役になる最旬パーカ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Kayiyasu】火ダウン
',
                'description' => '圧倒的な暖かさと存在感を放つ最旬ダウン',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Almalls】ヴィンテージTシャツ
',
                'description' => '古着のようなこなれ感を演出するお洒落Tシャツ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【長袖】Tシャツ',
                'description' => '何枚あっても困らない、肌触り抜群の定番ロンT',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Bonbon】ロールアップ七分丈シャツ
',
                'description' => '袖をラフに捲ってこなれ感を出す万能シャツ
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【楽天】ホワイトスキッパーシャツ
',
                'description' => '首元すっきり、抜け感を演出するキレイめ白シャツ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【SHEIN】ノースリーブパーカー',
                'description' => 'ストリート感抜群！こなれ見えするスリーブレス',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Joyesplay】フード付きノースリーブパーカー
',
                'description' => 'スポーティでレイヤードが楽しくなるフード服',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Temu】半袖チェックシャツ
',
                'description' => 'アメカジ風スタイルに最適な王道チェックシャツ',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【ANGJ】クルーネックリブニットカーディガン
',
                'description' => 'すっきり縦ラインで細見えする万能カーデ
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【エムシング】半袖綿麻混ブラウス
',
                'description' => 'サラッと涼しい綿麻素材のナチュラルブラウス
',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【辰の世界】刺繍ブラウス',
                'description' => '繊細な刺繍が目を惹く、華やかで上品なブラウス',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【INNIFER】Vネックブラウス
',
                'description' => 'デコルテを美しく魅せる、大人のキレイめ上品服',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Nike】靴10種',
                'description' => 'Nikeの人気のシューズを選出！',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Product::insert($data);
    }
}