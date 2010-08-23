<h1>Errorlog</h1>

<?php if(isset($message)): ?>
    <p class="message"><?php e($message);?></p>
<?php else: ?>

    <ul>
    	<li><a href="<?php e(url(null, array('unique' => true))); ?>">Unique</a></li>
    	<li><a href="<?php e(url(null . '.xml')); ?>">Rss</a></li>
    
    </ul>
    
    <form method="post" action="<?php e(url('.')); ?>"><p><strong>When you have corrected errors, you have to delete the log.</strong> <input type="submit" name="deletelog" value="Delete now" /></p></form>
    
    
    
    <?php if(isset($items) && is_array($items)): ?>
        <?php foreach($items AS $item): ?>
            <p>
                <strong><?php e($item['title']); ?></strong>
                <?php e($item['description']); ?><br />
                <?php e($item['pubDate']); ?>: <em><a href="<?php e($item['link']); ?>"><?php e($item['link']); ?></a></em>
            <?php if($has_translation && preg_match("/^Translation2: Missing translation for \"([a-zA-ZæøåÆØÅ _-]+)\" on pageID: \"([a-zA-ZæøåÆØÅ -=?%_]+)\"/", $item['title'], $params)): ?>
                <a href="<?php /*e(url('/translation', array('edit_id' => $params[1], 'page_id' => $params[2]))); */ ?>">Add translation</a>
            <?php endif; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>

<?php endif; ?>