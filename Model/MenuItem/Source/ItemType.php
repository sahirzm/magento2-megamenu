<?php
namespace Sahir\MegaMenu\Model\MenuItem\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ItemType implements OptionSourceInterface
{
    protected $itemTypes = [
        0 => 'Category',
        1 => 'Url',
        2 => 'Products',
        3 => 'CMS Page'
    ];

    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $options = [];
        foreach ($this->itemTypes as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        $this->options = $options;

        return $this->options;
    }
}
