<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
?>
<p><?= $block->escapeHtml($block->getMethod()->getTitle()) ?></p>
<?php if ($block->getInformation()): ?>
    <table>
        <tbody>
            <tr>
                <td><?= /* @noEscape */ nl2br($block->escapeHtml($block->getInformation())) ?></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>