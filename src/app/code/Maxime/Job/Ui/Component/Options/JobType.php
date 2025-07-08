<?php

namespace Maxime\Job\Ui\Component\Options;

use Magento\Framework\Data\OptionSourceInterface;

class JobType implements OptionSourceInterface
{
  public function toOptionArray()
  {
    return [
      ['value' => 'full_time', 'label' => __('Full Time')],
      ['value' => 'part_time', 'label' => __('Part Time')],
      ['value' => 'internship', 'label' => __('Internship')],
    ];
  }
}
