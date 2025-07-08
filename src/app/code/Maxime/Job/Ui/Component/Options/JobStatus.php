<?php

namespace Maxime\Job\Ui\Component\Options;

use Magento\Framework\Data\OptionSourceInterface;

class JobStatus implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Enabled')],
            ['value' => 0, 'label' => __('Disabled')],
        ];
    }
}
