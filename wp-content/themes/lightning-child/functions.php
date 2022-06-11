<?php
/**
 * Lightning Child theme functions
 *
 * @package lightning
 */

/************************************************
 * 独自CSSファイルの読み込み処理
 *
 * 主に CSS を SASS で 書きたい人用です。 素の CSS を直接書くなら style.css に記載してかまいません.
 */

// 独自のCSSファイル（assets/css/）を読み込む場合は true に変更してください.
$my_lightning_additional_css = false;

if ( $my_lightning_additional_css ) {
	// 公開画面側のCSSの読み込み.
	add_action(
		'wp_enqueue_scripts',
		function() {
			wp_enqueue_style(
				'my-lightning-custom',
				get_stylesheet_directory_uri() . '/assets/css/style.css',
				array( 'lightning-design-style' ),
				filemtime( dirname( __FILE__ ) . '/assets/css/style.css' )
			);
		}
	);
	// 編集画面側のCSSの読み込み.
	add_action(
		'enqueue_block_editor_assets',
		function() {
			wp_enqueue_style(
				'my-lightning-editor-custom',
				get_stylesheet_directory_uri() . '/assets/css/editor.css',
				array( 'wp-edit-blocks', 'lightning-gutenberg-editor' ),
				filemtime( dirname( __FILE__ ) . '/assets/css/editor.css' )
			);
		}
	);
}

/************************************************
 * 独自の処理を必要に応じて書き足します
 */
/**
 * 投稿一覧画面で表示する投稿情報に要素を追加する
 *
 * @param array  $options : 1件分の表示形式に関する設定配列.
 * @param object $post : 1件分の投稿情報.
 */
add_filter(
	'vk_post_options',
	function( $options, $post ) {

			// テキスト部分の前に要素を追加
			//$options['body_prepend'] = '<p class="alert alert-info">前に追加</p>';

			// テキスト部分の後に要素を追加
			// /$options['body_append'] = '<p class="alert alert-warning">後に追加</p>';

		// 改変した $options を返す
		return $options;
	},
	10,
	2
);

/**
 * 投稿一覧画面で表示する投稿情報にカスタムフィールドの値を追加する
 *
 * @param array  $options : 1件分の表示形式に関する設定配列.
 * @param object $post : 1件分の投稿情報.
 */
add_filter(
	'vk_post_options',
	function ( $options, $post ) {

		// 表示したい投稿タイプを条件分岐で指定.
		if ( 'post' === get_post_type() ) {

			/************************************
			 * カスタムフィールドの値など独自に表示したい要素を一旦 $insert_html に格納する.
			 */

			$body_append_html = '';
			// 家賃の入力がある場合
			if (  is_home() || is_front_page() ) {
		
				$body_append_html .= '<table class="table-sm mt-3">';
				// カスタムフィールド kanrihi / reikin / chikunen の値をそれぞれ表示.
				$body_append_html .= '<tr><th>店舗紹介</th><td class="text-right">' . esc_html( get_field('shop', $post->ID)) . '</td></tr>';
				$body_append_html .= '<tr><th>電話番号</th><td class="text-right">' . esc_html( get_field('phone', $post->ID)) . '</td></tr>';
				$body_append_html .= '<tr><th>営業時間</th><td class="text-right">' . esc_html( get_field('time', $post->ID )) . '</td></tr>';
				$body_append_html .= '</table>';

				/************************************
				 * 投稿１件分の 最後に追加
				 * （最初に追加する場合は body_append の部分を body_prepend に変更 ）.
				 */
				$options['body_append'] .= $body_append_html;
			}
		}
		// 投稿タイプ post の時に画像を無しに改変するが、投稿詳細ページでは改変させない.
		if ( 'post' === get_post_type() && ! is_single() ) {
			// $options の 'display_image' の値を上書き
			$options['display_image'] = true;
		}
		// 投稿タイプ post の時に画像を無しに改変するが、カードインテキストのレイアウトが選択されている場合は改変しない.
		if ( 'post' === get_post_type() && 'card-intext' !== $options['layout'] ) {
			// $options の 'display_image' の値を上書き
			$options['display_image'] = true;
		}		
		return $options;
	},
	10,
	2
);