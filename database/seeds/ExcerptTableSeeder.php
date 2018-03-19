<?php

use Illuminate\Database\Seeder;
use App\Excerpt;

class ExcerptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        return [
            Excerpt::create(['content' => 'When the people fear the government, there is tyranny. When government fears the people, there is liberty.', 'author' => 'Thomas Jefferson']),
            Excerpt::create(['content' => 'Education is the most powerful weapon which you can use to change the world.', 'author' => 'Nelson Mandela']),
            Excerpt::create(['content' => 'The only thing necessary for the triumph of evil is for good men to do nothing.', 'author' => 'Edmund Burke']),
            Excerpt::create(['content' => 'If your actions inspire others to dream more, learn more, do more and become more, you are a leader.', 'author' => 'John Quincy Adams']),
            Excerpt::create(['content' => 'It is better to be defeated standing for a high principle than to run by committing subterfuge.', 'author' => 'Grover Cleveland']),
            Excerpt::create(['content' => 'Men are not prisoners of fate, but only prisoners of their own minds.', 'author' => 'Franklin D. Roosevelt']),
            Excerpt::create(['content' => 'Pessimism never won any battle.', 'author' => 'Dwight D. Eisenhower']),
            Excerpt::create(['content' => 'Efforts and courage are not enough without purpose and direction.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'In the councils of government, we must guard against the acquisition of unwarranted influence, whether sought or unsought, by the military-industrial complex. The potential for the disastrous rise of misplaced power exists and will persist.', 'author' => 'Dwight D Eisenhower']),
            Excerpt::create(['content' => 'The prospect of domination of the nation\'s scholars by Federal employment, project allocations, and the power of money is ever present – and is gravely to be regarded.', 'author' => 'Dwight D Eisenhower']),
            Excerpt::create(['content' => 'Those who make peaceful revolution impossible will make violent revolution inevitable.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'Ask not what your country can do for you; Ask what you can do for your country.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'Conformity is the jailer of freedom and the enemy of growth.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'The goal of education is the advancement of knowledge and the dissemination of truth.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'A nation that is afraid to let its people judge the truth and falsehood in an open market is a nation that is afraid of its people.', 'author' => 'John F. Kennedy']),

            //Excerpt::create(['content' => '...', 'author' => '...'])
        ];
    }
}
