<?php

namespace LuisCusihuaman\Analytics\DomainEvents\Domain;

interface DomainEventsRepository
{
    public function save(AnalyticsDomainEvent $event): void;
}
