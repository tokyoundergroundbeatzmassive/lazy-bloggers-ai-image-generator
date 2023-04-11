↓↓↓English Below↓↓↓

「text2image-generator」について
このWordPressプラグインは、記事のタイトル、カテゴリー、タグを基に、記事が'公開'されるとOpenAIのAPIを利用して自動でアイキャッチ画像を生成します。

インストール手順:
	1.	GitHubからzipファイルをダウンロードします。
	2.	Wordpressの管理画面から「プラグイン」→「新規追加」を選択します。
	3.	「プラグインをアップロード」を選択し、ダウンロードしたzipファイルをアップロードします。
	4.	アップロードが完了したら「有効化」をクリックします。
	5.	管理画面内の設定内に「text2image-generator」が出てきます。

設定:
	1.	API Key: OpenAIのAPI Keyを入力します。
	2.	Size: 生成する画像のサイズを選択します。
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
このプラグインの最終目標はWordPressとOpenAIのAPIを使った多機能なプラグインだと考えています。例えば、Fine-tuningを使い、特定の知識特化型のブログ自動作成が可能になります。
開発には時開とお金がかかりますので、開発をサポートしていただける方は、以下の方法でドネーションいただけるとやる気が出ます。
Buy Me a Coffee: https://www.buymeacoffee.com/anonymously
PayPal: https://www.paypal.com/paypalme/tubm?locale.x=ja_JP


~English~
About "text2image-generator"
This WordPress plugin automatically generates featured images for your posts using OpenAI's API when the post is published, based on the title, category, and tags. 

Installation steps:
1. Download the zip file from GitHub.
2. In the WordPress admin panel, go to "Plugins" → "Add New."
3. Select "Upload Plugin" and upload the downloaded zip file.
4. Once the upload is complete, click "Activate."
5. You'll find "text2image-generator" in the Settings section of the admin panel.

Settings:
1. API Key: Enter your OpenAI API Key.
2. Size: Choose the size of the generated images.
3. Include Title/Category/Tag: Check these boxes to include the title, category, and tags in the API prompt.
4. Enable Translation: Enable this to translate the final prompt sent to the API into English.
5. Prompt: Use this to include style and scene information in the prompt.
6. Enable Logging: Enable this to save logs.

Dependencies:
As this plugin uses OpenAI's API to generate images, an API Key is required.
If 'Enable Translation' is enabled, the plugin will send requests to Open AI's API. It will not send requests if it is disabled.
The plugin sends prompts to Open AI's API to generate images.
The 'Enable Translation' toggle is located in the Settings.js file inside the plugin folder.

Bug reports and requests:
If you have any bug reports or feature requests for this plugin, please let us know through the "Issues" section on GitHub.

License:
This plugin is released under the MIT license.

Donation:
Our ultimate goal with this plugin is to create a multifunctional plugin using WordPress and OpenAI's API, such as auto-generating specialized knowledge-based blogs using Fine-tuning.
Development takes time and money, so if you'd like to support our work, please consider donating through the following methods:
Buy Me a Coffee: https://www.buymeacoffee.com/anonymously
PayPal: https://www.paypal.com/paypalme/tubm?locale.x=en_US
