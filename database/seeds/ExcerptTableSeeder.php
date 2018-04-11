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
            /* Adams */
            Excerpt::create(['content' => 'If your actions inspire others to dream more, learn more, do more and become more, you are a leader.', 'author' => 'John Quincy Adams']),           
            
            /* (Napoleon) Bonaparte */
            Excerpt::create(['content' => 'History is a set of lies agreed upon.', 'author' => 'Napoleon Bonaparte']),

            /* Burk */
            Excerpt::create(['content' => 'The only thing necessary for the triumph of evil is for good men to do nothing.', 'author' => 'Edmund Burke']),
            
            /* Cleveland */
            Excerpt::create(['content' => 'It is better to be defeated standing for a high principle than to run by committing subterfuge.', 'author' => 'Grover Cleveland']),           
            
            /* Einstein */
            Excerpt::create(['content' => 'A human being is part of a whole, called by us the \'Universe\' - a part limited in time and space. He experiences himself, his thoughts, and feelings, as something separated from the rest - a kind of optical delusion of his consciousness. This delusion is a kind of prison for us, restricting us to our personal desires and to affection for a few persons nearest us. Our task must be to free ourselves from this prison by widening our circles of compassion to embrace all living creatures and the whole of nature in its beauty.', 'author' => 'Albert Einstein']),
            
            /* Eisenhower */
            Excerpt::create(['content' => 'Pessimism never won any battle.', 'author' => 'Dwight D. Eisenhower']),
            Excerpt::create(['content' => 'In the councils of government, we must guard against the acquisition of unwarranted influence, whether sought or unsought, by the military-industrial complex. The potential for the disastrous rise of misplaced power exists and will persist.', 'author' => 'Dwight D Eisenhower']),
            Excerpt::create(['content' => 'The prospect of domination of the nation\'s scholars by Federal employment, project allocations, and the power of money is ever present – and is gravely to be regarded.', 'author' => 'Dwight D Eisenhower']),

            /* Ghandi */
            Excerpt::create(['content' => 'You can chain me, you can torture me, you can even destroy this body, but you will never imprison my mind.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'You must be the change you wish to see in the world.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Strength does not come from physical capacity. It comes from an indomitable will.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Those who know how to think need no teachers.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Truth stands, even if there be no public support. It is self-sustained.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Healthy discontent is the prelude to progress.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Truth never damages a cause that is just.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'An error does not become truth by reason of multiplied propagation, nor does truth become error because nobody sees it.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'Truth is by nature self-evident. As soon as you remove the cobwebs of ignorance that surround it, it shines clear.', 'author' => 'Mahatma Gandhi']),
            Excerpt::create(['content' => 'The pursuit of truth does not permit violence on one\'s opponent.', 'author' => 'Mahatma Gandhi']),

            /* Inouye */
            Excerpt::create(['content' => 'There exists a shadowy government with its own Air Force, its own Navy, its own fundraising mechanism, and the ability to pursue its own ideas of national interest, free from all checks and balances, and free from the law itself.', 'author' => 'Senator Daniel Inouye']),

            /* Jefferson */
            Excerpt::create(['content' => 'When the people fear the government, there is tyranny. When government fears the people, there is liberty.', 'author' => 'Thomas Jefferson']),
            
            /* Kennedy */
            Excerpt::create(['content' => 'Efforts and courage are not enough without purpose and direction.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'Those who make peaceful revolution impossible will make violent revolution inevitable.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'Ask not what your country can do for you; Ask what you can do for your country.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'Conformity is the jailer of freedom and the enemy of growth.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'The goal of education is the advancement of knowledge and the dissemination of truth.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'A nation that is afraid to let its people judge the truth and falsehood in an open market is a nation that is afraid of its people.', 'author' => 'John F. Kennedy']),            
            Excerpt::create(['content' => 'The very word \'secrecy\' is repugnant in a free and open society; and we are as a people inherently and historically opposed to secret societies, to secret oaths, and to secret proceedings.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => 'We decided long ago that the dangers of excessive and unwarranted concealment of pertinent facts far outweighed the dangers which are cited to justify it.', 'author' => 'John F. Kennedy']),
            Excerpt::create(['content' => '.. There is very grave danger that an announced need for increased security will be seized upon by those anxious to expand its meaning to the very limits of official censorship and concealment. That I do not intend to permit to the extent that it is in my control..', 'author' => 'John F. Kennedy']),
            
            /* Mandela */
            Excerpt::create(['content' => 'Education is the most powerful weapon which you can use to change the world.', 'author' => 'Nelson Mandela']),
            
            /* Roosevelt */
            Excerpt::create(['content' => 'Men are not prisoners of fate, but only prisoners of their own minds.', 'author' => 'Franklin D. Roosevelt']),
            
            /* Santayana */
            Excerpt::create(['content' => 'Those who cannot remember the past are condemned to repeat it.', 'author' => 'George Santayana']),

            /* Tesla */
            Excerpt::create(['content' => 'Let the future tell the truth, and evaluate each one according to his work and accomplishments. The present is theirs; the future, for which I have really worked, is mine.', 'author' => 'Nikola Tesla']),
            Excerpt::create(['content' => 'The scientific man does not aim at an immediate result. He does not expect that his advanced ideas will be readily taken up. His work is like that of the planter - for the future. His duty is to lay the foundation for those who are to come, and point the way.', 'author' => 'Nikola Tesla']),
            
            /* Wilde */
            Excerpt::create(['content' => 'Man is least himself when he talks in his own person. Give him a mask, and he will tell you the truth.', 'author' => 'Oscar Wilde'])
    
            //Excerpt::create(['content' => '', 'author' => ''])
        ];
    }
}
