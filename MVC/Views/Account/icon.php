<div class="emoji-category">
    <span class="emoji" onclick="selectEmoji('😀')">😀</span>
    <span class="emoji" onclick="selectEmoji('😃')">😃</span>
    <span class="emoji" onclick="selectEmoji('😄')">😄</span>
    <span class="emoji" onclick="selectEmoji('😆')">😆</span>
    <span class="emoji" onclick="selectEmoji('😅')">😅</span>
    <span class="emoji" onclick="selectEmoji('😂')">😂</span>
    <span class="emoji" onclick="selectEmoji('🤣')">🤣</span>
    <span class="emoji" onclick="selectEmoji('🥲')">🥲</span>
    <span class="emoji" onclick="selectEmoji('🥹')">🥹</span>
    <span class="emoji" onclick="selectEmoji('😊')">😊</span>
    <span class="emoji" onclick="selectEmoji('😇')">😇</span>
    <span class="emoji" onclick="selectEmoji('🙂')">🙂</span>
    <span class="emoji" onclick="selectEmoji('🙃')">🙃</span>
    <span class="emoji" onclick="selectEmoji('😉')">😉</span>
    <span class="emoji" onclick="selectEmoji('😌')">😌</span>
    <span class="emoji" onclick="selectEmoji('😍')">😍</span>
    <span class="emoji" onclick="selectEmoji('😘')">😘</span>
    <span class="emoji" onclick="selectEmoji('😗')">😗</span>
    <span class="emoji" onclick="selectEmoji('😙')">😙</span>
    <span class="emoji" onclick="selectEmoji('😚')">😚</span>
    <span class="emoji" onclick="selectEmoji('😋')">😋</span>
    <span class="emoji" onclick="selectEmoji('😛')">😛</span>
    <span class="emoji" onclick="selectEmoji('😝')">😝</span>
    <span class="emoji" onclick="selectEmoji('😜')">😜</span>
    <span class="emoji" onclick="selectEmoji('🤪')">🤪</span>
    <span class="emoji" onclick="selectEmoji('🤨')">🤨</span>
    <span class="emoji" onclick="selectEmoji('🧐')">🧐</span>
    <span class="emoji" onclick="selectEmoji('🤓')">🤓</span>
    <span class="emoji" onclick="selectEmoji('😎')">😎</span>
    <span class="emoji" onclick="selectEmoji('🤩')">🤩</span>
    <span class="emoji" onclick="selectEmoji('🥳')">🥳</span>
    <span class="emoji" onclick="selectEmoji('😕')">😕</span>
    <span class="emoji" onclick="selectEmoji('😣')">😣</span>
    <span class="emoji" onclick="selectEmoji('😖')">😖</span>
    <span class="emoji" onclick="selectEmoji('😫')">😫</span>
    <span class="emoji" onclick="selectEmoji('😩')">😩</span>
    <span class="emoji" onclick="selectEmoji('🥺')">🥺</span>
    <span class="emoji" onclick="selectEmoji('😢')">😢</span>
    <span class="emoji" onclick="selectEmoji('😭')">😭</span>
    <span class="emoji" onclick="selectEmoji('😮‍💨')">😮‍💨</span>
    <span class="emoji" onclick="selectEmoji('😤')">😤</span>
    <span class="emoji" onclick="selectEmoji('😠')">😠</span>
    <span class="emoji" onclick="selectEmoji('😡')">😡</span>
    <span class="emoji" onclick="selectEmoji('🤬')">🤬</span>
    <span class="emoji" onclick="selectEmoji('🤯')">🤯</span>
    <span class="emoji" onclick="selectEmoji('😳')">😳</span>
    <span class="emoji" onclick="selectEmoji('🥵')">🥵</span>
    <span class="emoji" onclick="selectEmoji('🥶')">🥶</span>
    <span class="emoji" onclick="selectEmoji('😱')">😱</span>
    <span class="emoji" onclick="selectEmoji('😨')">😨</span>
    <span class="emoji" onclick="selectEmoji('😰')">😰</span>
    <span class="emoji" onclick="selectEmoji('😥')">😥</span>
    <span class="emoji" onclick="selectEmoji('🫣')">🫣</span>
    <span class="emoji" onclick="selectEmoji('🤗')">🤗</span>
</div>
<script>
    function toggleEmojiPicker() {
        const emojiPicker = document.getElementById('emojiPicker');
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
    }
    function selectEmoji(emoji) {
        document.querySelector('textarea').value += emoji;

    }
    function hideEmojiPickerIfClickedOutside(event) {
        const emojiPicker = document.getElementById('emojiPicker');
        const isClickInsideEmojiPicker = emojiPicker.contains(event.target);
        const isClickOnButton = event.target.closest('button'); // Check if click is on any button
        if (!isClickInsideEmojiPicker && !isClickOnButton) {
            emojiPicker.style.display = 'none';
        }
    }
</script>