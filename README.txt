「text2image-generator」について
このWordPressプラグインは、記事のタイトル、カテゴリー、タグを基に、記事が'公開'されるとOpenAIのAPIを利用して自動でアイキャッチ画像を生成します。使い方は簡単で、GitHubからzipファイルをダウンロードし、通常のWordPressと同じ方法でインストールするだけです。
インストール手順:
	1.	GitHubからzipファイルをダウンロードします。
	2.	Wordpressの管理画面から「プラグイン」→「新規追加」を選択します。
	3.	「プラグインをアップロード」を選択し、ダウンロードしたzipファイルをアップロードします。
	4.	アップロードが完了したら「有効化」をクリックします。
	5.	管理画面内の設定内に「text2image-generator」が出てきます。
設定:
	1.	API Key: OpenAIのAPI Keyを入力します。
	2.	画像サイズ: 生成する画像のサイズを選択します。
	3.	Include Title/Category/Tag: それぞれのチェックボックスを入れると、APIに送られるプロンプトにタイトル、カテゴリー、タグが含まれるようになります。
	4.	Enable Translation: 有効にすると、APIに送られる最終的なプロンプトが英語に翻訳されます。
	5.	Prompt: スタイルやシーンをプロンプトに含めるために使います。
	6.	Enable Logging: 有効にするとログを保存します。
依存関係:
OpenAIのAPIを利用して画像を生成するため、API Keyが必要です。
'Enable Translation'が有効の場合、Open AIのAPIにリクエストを送ります。無効な場合には送りません。
画像を生成するためにOpen AIのAPIにプロンプトを送ります。
プラグインフォルダ内にあるSettings.jsで'Enable Translation'を有効・無効を切り替えています。
バグ報告やリクエスト:
このプラグインに対してバグ報告や機能リクエストがありましたら、GitHubの「Issues」セクションからお知らせください。
ライセンス:
このプラグインはMITライセンスで公開されています。
ドネーション:
このプラグインの最終目標はWordPressとOpenAIのAPIを使った多機能なプラグインだと考えています。例えば、Fine-tuningを使った特定の知識特化型のブログ自動作成が可能になります。
開発には時開とお金がかかりますので、開発をサポートしていただける方は、以下の方法でドネーションいただけるとやる気が出ます。
Buy Me a Coffee: https://www.buymeacoffee.com/anonymously
PayPal: https://www.paypal.com/paypalme/tubm?locale.x=ja_JP