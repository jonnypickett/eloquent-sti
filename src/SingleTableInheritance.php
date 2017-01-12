<?php

namespace JonnyPickett\EloquentSTI;

trait SingleTableInheritance
{
    /**
     * Check that class is a subclass
     *
     * @return bool
     */
    public function isSubclass()
    {
        return (get_parent_class($this) != static::class) && is_subclass_of($this, self::class);
    }

    /**
     * @return bool
     */
    public function hasValidSubclassField()
    {
        if (property_exists($this, 'subclassField')) {
            return isset($this->subclassField);
        }
        return (bool) config('eloquent-sti.subclass_field');
    }

    /**
     * @return string|null
     */
    public function getSubClassField()
    {
        if ($this->hasValidSubclassField()) {
            return $this->subclassField ?: config('eloquent-sti.subclass_field');
        }
        return null;
    }

    /**
     * @return bool
     */
    public function usesSTI()
    {
        return $this->hasValidSubclassField();
    }

    /**
     * If no subclass is defined, function as normal
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function mapData(array $attributes)
    {
        if (!$this->usesSTI()) {
            return $this->newInstance();
        }

        return new $attributes[$this->getSubClassField()];
    }

    /**
     * Instead of using $this->newInstance(), call
     * newInstance() on the object from mapData
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function newFromBuilder($attributes = array(), $connection = null)
    {
        $instance = $this->mapData((array) $attributes)->newInstance(array(), true);
        $instance->setRawAttributes((array) $attributes, true);
        return $instance;
    }

    /**
     * @return mixed
     */
    public function newQuery()
    {
        $builder = parent::newQuery();

        if ($this->hasValidSubclassField() && $this->isSubclass()) {
            $builder->where($this->getSubClassField(), '=', get_class($this));
        }

        return $builder;
    }

    /**
     * Ensure that the subclass field is assigned on save
     *
     * @param array $options
     *
     * @return mixed
     */
    public function save(array $options = [])
    {
        if ($this->hasValidSubclassField()) {
            $this->attributes[$this->getSubClassField()] = get_class($this);
        }
        return parent::save($options);
    }

    /**
     * Update the model in the database.
     *
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        return parent::save($options);
    }
}
